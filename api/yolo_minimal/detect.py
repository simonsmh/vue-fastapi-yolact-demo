import cv2
import numpy as np
import torch

from .models import Darknet
from .utils import (
    letterbox,
    non_max_suppression,
    scale_coords,
    get_file_location,
)


def detect_init(cfg="yolov3-spp-buoy.cfg", weights="best_buoy.pt", img_size=512):
    cfg, weights = get_file_location(cfg), get_file_location(weights)
    device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")
    # Initialize model
    model = Darknet(cfg, img_size)
    model.load_state_dict(torch.load(weights, map_location=device)["model"])
    model.to(device).eval()
    return model


def detect(byte, model, img_size=512):
    device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")
    # Read and preprocess image from ram
    img0 = cv2.imdecode(np.frombuffer(byte, np.uint8), 1)
    img = letterbox(img0, new_shape=img_size)[0]
    img = img[:, :, ::-1].transpose(2, 0, 1)  # BGR to RGB, to 3x416x416
    img = np.ascontiguousarray(img)
    img = torch.from_numpy(img).to(device).float()  # uint8 to fp32
    img /= 255.0  # 0 - 255 to 0.0 - 1.0
    img = img.unsqueeze(0)
    pred = model(img)[0]
    pred = non_max_suppression(pred, 0.3, 0.6)
    for det in pred:
        if det is not None and len(det):
            # Rescale boxes from img_size to im0 size
            det[:, :4] = scale_coords(img.shape[2:], det[:, :4], img0.shape).round()
            return det.detach().to("cpu").numpy().tolist()
        else:
            return list()


def parse_name(files="buoy.names"):
    with open(get_file_location(files)) as file:
        labels = file.read().splitlines()
    name = files.split(".")[0] if "." in files else files
    return (name, labels)
