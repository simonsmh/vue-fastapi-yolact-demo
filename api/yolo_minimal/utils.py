import math
import os
import random

import cv2
import numpy as np
import torch
import torch.nn as nn
import torch.nn.functional as F
import torchvision


def xyxy2xywh(x):
    # Transform box coordinates from [x1, y1, x2, y2] (where xy1=top-left, xy2=bottom-right) to [x, y, w, h]
    y = torch.zeros_like(x) if isinstance(x, torch.Tensor) else np.zeros_like(x)
    y[:, 0] = (x[:, 0] + x[:, 2]) / 2  # x center
    y[:, 1] = (x[:, 1] + x[:, 3]) / 2  # y center
    y[:, 2] = x[:, 2] - x[:, 0]  # width
    y[:, 3] = x[:, 3] - x[:, 1]  # height
    return y


def xywh2xyxy(x):
    # Transform box coordinates from [x, y, w, h] to [x1, y1, x2, y2] (where xy1=top-left, xy2=bottom-right)
    y = torch.zeros_like(x) if isinstance(x, torch.Tensor) else np.zeros_like(x)
    y[:, 0] = x[:, 0] - x[:, 2] / 2  # top left x
    y[:, 1] = x[:, 1] - x[:, 3] / 2  # top left y
    y[:, 2] = x[:, 0] + x[:, 2] / 2  # bottom right x
    y[:, 3] = x[:, 1] + x[:, 3] / 2  # bottom right y
    return y


def scale_coords(img1_shape, coords, img0_shape, ratio_pad=None):
    # Rescale coords (xyxy) from img1_shape to img0_shape
    gain = max(img1_shape) / max(img0_shape)  # gain  = old / new
    pad = (
        (img1_shape[1] - img0_shape[1] * gain) / 2,
        (img1_shape[0] - img0_shape[0] * gain) / 2,
    )  # wh padding
    coords[:, [0, 2]] -= pad[0]  # x padding
    coords[:, [1, 3]] -= pad[1]  # y padding
    coords[:, :4] /= gain
    clip_coords(coords, img0_shape)
    coords[:, 2] -= coords[:, 0]  # xyxy2xywh
    coords[:, 3] -= coords[:, 1]
    return coords


def clip_coords(boxes, img_shape):
    # Clip bounding xyxy bounding boxes to image shape (height, width)
    boxes[:, 0].clamp_(0, img_shape[1])  # x1
    boxes[:, 1].clamp_(0, img_shape[0])  # y1
    boxes[:, 2].clamp_(0, img_shape[1])  # x2
    boxes[:, 3].clamp_(0, img_shape[0])  # y2


def bbox_iou(box1, box2, x1y1x2y2=True, GIoU=False, DIoU=False, CIoU=False):
    # Returns the IoU of box1 to box2. box1 is 4, box2 is nx4
    box2 = box2.t()

    # Get the coordinates of bounding boxes
    if x1y1x2y2:  # x1, y1, x2, y2 = box1
        b1_x1, b1_y1, b1_x2, b1_y2 = box1[0], box1[1], box1[2], box1[3]
        b2_x1, b2_y1, b2_x2, b2_y2 = box2[0], box2[1], box2[2], box2[3]
    else:  # transform from xywh to xyxy
        b1_x1, b1_x2 = box1[0] - box1[2] / 2, box1[0] + box1[2] / 2
        b1_y1, b1_y2 = box1[1] - box1[3] / 2, box1[1] + box1[3] / 2
        b2_x1, b2_x2 = box2[0] - box2[2] / 2, box2[0] + box2[2] / 2
        b2_y1, b2_y2 = box2[1] - box2[3] / 2, box2[1] + box2[3] / 2

    # Intersection area
    inter = (torch.min(b1_x2, b2_x2) - torch.max(b1_x1, b2_x1)).clamp(0) * (
        torch.min(b1_y2, b2_y2) - torch.max(b1_y1, b2_y1)
    ).clamp(0)

    # Union Area
    w1, h1 = b1_x2 - b1_x1, b1_y2 - b1_y1
    w2, h2 = b2_x2 - b2_x1, b2_y2 - b2_y1
    union = (w1 * h1 + 1e-16) + w2 * h2 - inter

    iou = inter / union  # iou
    if GIoU or DIoU or CIoU:
        cw = torch.max(b1_x2, b2_x2) - torch.min(
            b1_x1, b2_x1
        )  # convex (smallest enclosing box) width
        ch = torch.max(b1_y2, b2_y2) - torch.min(b1_y1, b2_y1)  # convex height
        if GIoU:  # Generalized IoU https://arxiv.org/pdf/1902.09630.pdf
            c_area = cw * ch + 1e-16  # convex area
            return iou - (c_area - union) / c_area  # GIoU
        if DIoU or CIoU:  # Distance or Complete IoU https://arxiv.org/abs/1911.08287v1
            # convex diagonal squared
            c2 = cw ** 2 + ch ** 2 + 1e-16
            # centerpoint distance squared
            rho2 = ((b2_x1 + b2_x2) - (b1_x1 + b1_x2)) ** 2 / 4 + (
                (b2_y1 + b2_y2) - (b1_y1 + b1_y2)
            ) ** 2 / 4
            if DIoU:
                return iou - rho2 / c2  # DIoU
            elif (
                CIoU
            ):  # https://github.com/Zzh-tju/DIoU-SSD-pytorch/blob/master/utils/box/box_utils.py#L47
                v = (4 / math.pi ** 2) * torch.pow(
                    torch.atan(w2 / h2) - torch.atan(w1 / h1), 2
                )
                with torch.no_grad():
                    alpha = v / (1 - iou + v)
                return iou - (rho2 / c2 + v * alpha)  # CIoU

    return iou


def box_iou(box1, box2):
    # https://github.com/pytorch/vision/blob/master/torchvision/ops/boxes.py
    """
    Return intersection-over-union (Jaccard index) of boxes.
    Both sets of boxes are expected to be in (x1, y1, x2, y2) format.
    Arguments:
        box1 (Tensor[N, 4])
        box2 (Tensor[M, 4])
    Returns:
        iou (Tensor[N, M]): the NxM matrix containing the pairwise
            IoU values for every element in boxes1 and boxes2
    """

    def box_area(box):
        # box = 4xn
        return (box[2] - box[0]) * (box[3] - box[1])

    area1 = box_area(box1.t())
    area2 = box_area(box2.t())

    # inter(N,M) = (rb(N,M,2) - lt(N,M,2)).clamp(0).prod(2)
    inter = (
        (
            torch.min(box1[:, None, 2:], box2[:, 2:])
            - torch.max(box1[:, None, :2], box2[:, :2])
        )
        .clamp(0)
        .prod(2)
    )
    return inter / (
        area1[:, None] + area2 - inter
    )  # iou = inter / (area1 + area2 - inter)


def wh_iou(wh1, wh2):
    # Returns the nxm IoU matrix. wh1 is nx2, wh2 is mx2
    wh1 = wh1[:, None]  # [N,1,2]
    wh2 = wh2[None]  # [1,M,2]
    inter = torch.min(wh1, wh2).prod(2)  # [N,M]
    return inter / (
        wh1.prod(2) + wh2.prod(2) - inter
    )  # iou = inter / (area1 + area2 - inter)


def non_max_suppression(
    prediction,
    conf_thres=0.1,
    iou_thres=0.6,
    multi_label=True,
    classes=None,
    agnostic=False,
):
    """
    Performs  Non-Maximum Suppression on inference results
    Returns detections with shape:
        nx6 (x1, y1, x2, y2, conf, cls)
    """

    # Box constraints
    min_wh, max_wh = 2, 4096  # (pixels) minimum and maximum box width and height

    method = "merge"
    nc = prediction[0].shape[1] - 5  # number of classes
    multi_label &= nc > 1  # multiple labels per box
    output = [None] * len(prediction)

    for xi, x in enumerate(prediction):  # image index, image inference
        # Apply conf constraint
        x = x[x[:, 4] > conf_thres]

        # Apply width-height constraint
        x = x[((x[:, 2:4] > min_wh) & (x[:, 2:4] < max_wh)).all(1)]

        # If none remain process next image
        if not x.shape[0]:
            continue

        # Compute conf
        x[..., 5:] *= x[..., 4:5]  # conf = obj_conf * cls_conf

        # Box (center x, center y, width, height) to (x1, y1, x2, y2)
        box = xywh2xyxy(x[:, :4])

        # Detections matrix nx6 (xyxy, conf, cls)
        if multi_label:
            i, j = (x[:, 5:] > conf_thres).nonzero().t()
            x = torch.cat((box[i], x[i, j + 5].unsqueeze(1), j.float().unsqueeze(1)), 1)
        else:  # best class only
            conf, j = x[:, 5:].max(1)
            x = torch.cat((box, conf.unsqueeze(1), j.float().unsqueeze(1)), 1)

        # Filter by class
        if classes:
            x = x[(j.view(-1, 1) == torch.tensor(classes, device=j.device)).any(1)]

        # Apply finite constraint
        if not torch.isfinite(x).all():
            x = x[torch.isfinite(x).all(1)]

        # If none remain process next image
        n = x.shape[0]  # number of boxes
        if not n:
            continue

        # Sort by confidence
        # if method == 'fast_batch':
        #    x = x[x[:, 4].argsort(descending=True)]

        # Batched NMS
        c = x[:, 5] * 0 if agnostic else x[:, 5]  # classes
        boxes, scores = (
            x[:, :4].clone() + c.view(-1, 1) * max_wh,
            x[:, 4],
        )  # boxes (offset by class), scores
        if method == "merge":  # Merge NMS (boxes merged using weighted mean)
            i = torchvision.ops.boxes.nms(boxes, scores, iou_thres)
            if n < 1e4:  # update boxes as boxes(i,4) = weights(i,n) * boxes(n,4)
                # weights = (box_iou(boxes, boxes).tril_() > iou_thres) * scores.view(-1, 1)  # box weights
                # weights /= weights.sum(0)  # normalize
                # x[:, :4] = torch.mm(weights.T, x[:, :4])
                weights = (box_iou(boxes[i], boxes) > iou_thres) * scores[
                    None
                ]  # box weights
                x[i, :4] = torch.mm(
                    weights / weights.sum(1, keepdim=True), x[:, :4]
                ).float()  # merged boxes

        elif method == "vision":
            i = torchvision.ops.boxes.nms(boxes, scores, iou_thres)
        elif method == "fast":  # FastNMS from https://github.com/dbolya/yolact
            iou = box_iou(boxes, boxes).triu_(diagonal=1)  # upper triangular iou matrix
            i = iou.max(0)[0] < iou_thres

        output[xi] = x[i]
    return output


def model_info(model, verbose=False):
    # Plots a line-by-line description of a PyTorch model
    n_p = sum(x.numel() for x in model.parameters())  # number parameters
    n_g = sum(
        x.numel() for x in model.parameters() if x.requires_grad
    )  # number gradients
    if verbose:
        print(
            "%5s %40s %9s %12s %20s %10s %10s"
            % ("layer", "name", "gradient", "parameters", "shape", "mu", "sigma")
        )
        for i, (name, p) in enumerate(model.named_parameters()):
            name = name.replace("module_list.", "")
            print(
                "%5g %40s %9s %12g %20s %10.3g %10.3g"
                % (
                    i,
                    name,
                    p.requires_grad,
                    p.numel(),
                    list(p.shape),
                    p.mean(),
                    p.std(),
                )
            )

    try:  # FLOPS
        from thop import profile

        macs, _ = profile(model, inputs=(torch.zeros(1, 3, 480, 640),))
        fs = ", %.1f GFLOPS" % (macs / 1e9 * 2)
    except:
        fs = ""

    if verbose:
        print(
            "Model Summary: %g layers, %g parameters, %g gradients%s"
            % (len(list(model.parameters())), n_p, n_g, fs)
        )


def fuse_conv_and_bn(conv, bn):
    # https://tehnokv.com/posts/fusing-batchnorm-and-conv/
    with torch.no_grad():
        # init
        fusedconv = torch.nn.Conv2d(
            conv.in_channels,
            conv.out_channels,
            kernel_size=conv.kernel_size,
            stride=conv.stride,
            padding=conv.padding,
            bias=True,
        )

        # prepare filters
        w_conv = conv.weight.clone().view(conv.out_channels, -1)
        w_bn = torch.diag(bn.weight.div(torch.sqrt(bn.eps + bn.running_var)))
        fusedconv.weight.copy_(torch.mm(w_bn, w_conv).view(fusedconv.weight.size()))

        # prepare spatial bias
        if conv.bias is not None:
            b_conv = conv.bias
        else:
            b_conv = torch.zeros(conv.weight.size(0))
        b_bn = bn.bias - bn.weight.mul(bn.running_mean).div(
            torch.sqrt(bn.running_var + bn.eps)
        )
        fusedconv.bias.copy_(torch.mm(w_bn, b_conv.reshape(-1, 1)).reshape(-1) + b_bn)

        return fusedconv


def scale_img(img, ratio=1.0, same_shape=True):  # img(16,3,256,416), r=ratio
    # scales img(bs,3,y,x) by ratio
    h, w = img.shape[2:]
    s = (int(h * ratio), int(w * ratio))  # new size
    img = F.interpolate(img, size=s, mode="bilinear", align_corners=False)  # resize
    if not same_shape:  # pad/crop img
        gs = 64  # (pixels) grid size
        h, w = [math.ceil(x * ratio / gs) * gs for x in (h, w)]
    return F.pad(img, [0, w - s[1], 0, h - s[0]], value=0.447)  # value = imagenet mean


def parse_model_cfg(path):
    # Parse the yolo *.cfg file and return module definitions path may be 'cfg/yolov3.cfg', 'yolov3.cfg', or 'yolov3'
    if not path.endswith(".cfg"):  # add .cfg suffix if omitted
        path += ".cfg"
    if not os.path.exists(path) and os.path.exists(
        "cfg" + os.sep + path
    ):  # add cfg/ prefix if omitted
        path = "cfg" + os.sep + path

    with open(path, "r") as f:
        lines = f.read().split("\n")
    lines = [x for x in lines if x and not x.startswith("#")]
    lines = [x.rstrip().lstrip() for x in lines]  # get rid of fringe whitespaces
    mdefs = []  # module definitions
    for line in lines:
        if line.startswith("["):  # This marks the start of a new block
            mdefs.append({})
            mdefs[-1]["type"] = line[1:-1].rstrip()
            if mdefs[-1]["type"] == "convolutional":
                mdefs[-1][
                    "batch_normalize"
                ] = 0  # pre-populate with zeros (may be overwritten later)
        else:
            key, val = line.split("=")
            key = key.rstrip()

            if key == "anchors":  # return nparray
                mdefs[-1][key] = np.array([float(x) for x in val.split(",")]).reshape(
                    (-1, 2)
                )  # np anchors
            elif (key in ["from", "layers", "mask"]) or (
                key == "size" and "," in val
            ):  # return array
                mdefs[-1][key] = [int(x) for x in val.split(",")]
            else:
                val = val.strip()
                if val.isnumeric():  # return int or float
                    mdefs[-1][key] = (
                        int(val) if (int(val) - float(val)) == 0 else float(val)
                    )
                else:
                    mdefs[-1][key] = val  # return string

    # Check all fields are supported
    supported = [
        "type",
        "batch_normalize",
        "filters",
        "size",
        "stride",
        "pad",
        "activation",
        "layers",
        "groups",
        "from",
        "mask",
        "anchors",
        "classes",
        "num",
        "jitter",
        "ignore_thresh",
        "truth_thresh",
        "random",
        "stride_x",
        "stride_y",
        "weights_type",
        "weights_normalization",
        "scale_x_y",
        "beta_nms",
        "nms_kind",
        "iou_loss",
        "iou_normalizer",
        "cls_normalizer",
        "iou_thresh",
    ]

    f = []  # fields
    for x in mdefs[1:]:
        [f.append(k) for k in x if k not in f]
    u = [x for x in f if x not in supported]  # unsupported fields
    assert not any(u), (
        "Unsupported fields %s in %s. See https://github.com/ultralytics/yolov3/issues/631"
        % (u, path)
    )

    return mdefs


def letterbox(
    img,
    new_shape=(416, 416),
    color=(114, 114, 114),
    auto=True,
    scaleFill=False,
    scaleup=True,
):
    # Resize image to a 32-pixel-multiple rectangle https://github.com/ultralytics/yolov3/issues/232
    shape = img.shape[:2]  # current shape [height, width]
    if isinstance(new_shape, int):
        new_shape = (new_shape, new_shape)

    # Scale ratio (new / old)
    r = min(new_shape[0] / shape[0], new_shape[1] / shape[1])
    if not scaleup:  # only scale down, do not scale up (for better test mAP)
        r = min(r, 1.0)

    # Compute padding
    ratio = r, r  # width, height ratios
    new_unpad = int(round(shape[1] * r)), int(round(shape[0] * r))
    dw, dh = new_shape[1] - new_unpad[0], new_shape[0] - new_unpad[1]  # wh padding
    if auto:  # minimum rectangle
        dw, dh = np.mod(dw, 64), np.mod(dh, 64)  # wh padding
    elif scaleFill:  # stretch
        dw, dh = 0.0, 0.0
        new_unpad = new_shape
        ratio = new_shape[0] / shape[1], new_shape[1] / shape[0]  # width, height ratios

    dw /= 2  # divide padding into 2 sides
    dh /= 2

    if shape[::-1] != new_unpad:  # resize
        img = cv2.resize(img, new_unpad, interpolation=cv2.INTER_LINEAR)
    top, bottom = int(round(dh - 0.1)), int(round(dh + 0.1))
    left, right = int(round(dw - 0.1)), int(round(dw + 0.1))
    img = cv2.copyMakeBorder(
        img, top, bottom, left, right, cv2.BORDER_CONSTANT, value=color
    )  # add border
    return img, ratio, (dw, dh)


def get_file_location(path):
    if not os.path.exists(path) and os.path.exists(
        os.path.split(os.path.realpath(__file__))[0] + os.sep + path
    ):  # add $PWD/ prefix if omitted
        return os.path.split(os.path.realpath(__file__))[0] + os.sep + path
    else:
        return
