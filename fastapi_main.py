import base64
import logging
import time
from io import BytesIO

import cv2
import numpy
import torch
import uvicorn
from cv2 import cv2
from detectron2.config import get_cfg
from detectron2.data.datasets import register_coco_instances
from detectron2.data.detection_utils import (
    _apply_exif_orientation,
    convert_PIL_to_numpy,
    read_image,
)
from detectron2.utils.logger import setup_logger
from fastapi import Body, Depends, FastAPI, File, Request, Response, UploadFile
from fastapi.middleware.cors import CORSMiddleware
from PIL import Image

from rcnn.demo import get_parser, setup_cfg
from rcnn.predictor import VisualizationDemo
from yolact.eval import prep_display
from yolact.utils.augmentations import FastBaseTransform
from yolact.yolact import Yolact

origins = [
    "http://localhost",
    "http://localhost:3000",
    "http://localhost:8000",
]

logger = logging.getLogger()
app = FastAPI(root_path="")
app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

yolact = Yolact()
yolact.detect.use_fast_nms = True
yolact.load_weights("yolact/weights/buoy_yolact_resnet50_plus_823_121850_interrupt.pth")
yolact.eval()
yolact = yolact.cuda()
logger.info("Yolact Model init Done.")


def yolact_detect(stream: BytesIO):
    img = cv2.imdecode(numpy.frombuffer(stream.read(), numpy.uint8), cv2.IMREAD_COLOR)
    torch.set_default_tensor_type("torch.cuda.FloatTensor")
    frame = torch.from_numpy(img).cuda().float()
    batch = FastBaseTransform()(frame.unsqueeze(0))
    preds = yolact(batch)

    # Should draw mask by client
    img_numpy = prep_display(preds, frame, None, None, undo_transform=False)
    img_numpy = img_numpy[:, :, (2, 1, 0)]
    buf = BytesIO()
    detected_img = Image.fromarray(img_numpy)
    detected_img.save(buf, "JPEG", quality=95)
    img_str = base64.b64encode(buf.getvalue())
    return img_str


rcnn_args = get_parser().parse_args()
rcnn_args.config_file = "rcnn/buoy.yml"
rcnn = VisualizationDemo(setup_cfg(rcnn_args))
register_coco_instances(
    "buoy_dataset_valid",
    {"thing_classes": ["_background_", "buoy"]},
    "/mnt/d/Dataset/valid_cocobuoy/annotations.json",
    "/mnt/d/Dataset/valid_cocobuoy",
)
logger.info("Mask R-CNN Model init Done.")


def rcnn_detect(stream: BytesIO):
    # filepath = "/mnt/d/Dataset/png_buoy/buoy (2138).png"
    # with open(filepath, "rb") as f:
    with Image.open(stream) as image:
        img = convert_PIL_to_numpy(image, "BGR")

    _, visualized_output = rcnn.run_on_image(img)
    img_numpy = visualized_output.get_image()
    buf = BytesIO()
    detected_img = Image.fromarray(img_numpy)
    detected_img.save(buf, "JPEG", quality=95)
    img_str = base64.b64encode(buf.getvalue())
    return img_str


@app.get("/")
async def read_root():
    return {"return": 200}


@app.get("/yolact")
async def yolact_app():
    return {"return": 200}


@app.get("/rcnn")
async def rcnn_app():
    return {"return": 200}


@app.post("/yolact")
async def yolact_app_detect(file: UploadFile = File(...)):
    image_file = BytesIO(file.file.read())
    start_time = time.time()
    img_base64 = yolact_detect(image_file)
    return {
        "return": 200,
        "img": img_base64,
        "time": "{:.2f}".format(time.time() - start_time),
    }


@app.post("/rcnn")
async def rcnn_app_detect(file: UploadFile = File(...)):
    image_file = BytesIO(file.file.read())
    start_time = time.time()
    img_base64 = rcnn_detect(image_file)
    return {
        "return": 200,
        "img": img_base64,
        "time": "{:.2f}".format(time.time() - start_time),
    }


if __name__ == "__main__":
    uvicorn.run(app, host="127.0.0.1", port=8000)
