import os
import json
from matplotlib import rcParams
import matplotlib.pyplot as plt
import numpy as np

rcParams['font.sans-serif']=['SimHei']
rcParams['axes.unicode_minus']=False
# Loss Key:
#  - B: Box Localization Loss
#  - C: Class Confidence Loss
#  - M: Mask Loss
#  - P: Prototype Loss
#  - D: Coefficient Diversity Loss
#  - E: Class Existence Loss
#  - S: Semantic Segmentation Loss
# {'type': 'train', 'session': 0, 'data': {'loss': {'B': 1.86991, 'M': 1.50436, 'C': 1.7943, 'I': 0.11157, 'S': 0.02979, 'T': 5.30993}, 'epoch': 1, 'iter': 330, 'lr': 0.0004465, 'elapsed': 0.7185304164886475}, 'time': 1617462196.0522254}
# {"type": "val", "session": 0, "data": {"elapsed": 15.807188749313354, "epoch": 2, "iter": 531, "box": {"all": 33.71, "50": 91.01, "55": 77.8, "60": 70.5, "65": 54.92, "70": 31.79, "75": 8.87, "80": 2.14, "85": 0.1, "90": 0.0, "95": 0.0}, "mask": {"all": 58.24, "50": 92.64, "55": 90.38, "60": 88.33, "65": 80.09, "70": 76.34, "75": 68.15, "80": 59.73, "85": 23.92, "90": 2.65, "95": 0.17}}, "time": 1617462339.5965185}


targetstrs = ["yolact_resnet101", "yolact_resnet50"]

for targetstr in targetstrs:
    buoy_log_iter = []
    buoy_log_B = []
    buoy_log_M = []
    buoy_log_map_iter = []
    buoy_log_map_box = []
    buoy_log_map_mask = []
    with open(f"buoy_{targetstr}_plus.log") as f:
        while True:
            line = f.readline()
            if line:
                target = json.loads(line)
                if target.get("type") == "train":
                    buoy_log_iter.append(target.get("data").get("iter"))
                    buoy_log_B.append(target.get("data").get("loss").get("B"))
                    buoy_log_M.append(target.get("data").get("loss").get("M"))
                elif target.get("type") == "val":
                    # if target.get("data").get("iter") > 70000:
                    #     break
                    buoy_log_map_iter.append(target.get("data").get("iter"))
                    buoy_log_map_box.append(target.get("data").get("box").get("all"))
                    buoy_log_map_mask.append(target.get("data").get("mask").get("all"))
            else:
                break

    plt.title(f"{targetstr} 损失曲线")
    plt.xlabel("迭代")
    plt.ylabel("Loss")
    plt.plot(buoy_log_iter, buoy_log_B, linewidth=1, alpha=0.7)
    plt.plot(buoy_log_iter, buoy_log_M, linewidth=1, alpha=0.7)
    plt.legend([f"{targetstr}目标框位置", f"{targetstr}掩膜位置"])
    plt.savefig(f"{targetstr}_损失曲线.jpg")
    plt.clf()
    plt.title("mAP@.5:.95精度曲线")
    plt.xlabel("迭代")
    plt.ylabel("分数")
    plt.plot(buoy_log_map_iter, buoy_log_map_box)
    plt.plot(buoy_log_map_iter, buoy_log_map_mask)
    plt.legend([f"{targetstr}目标框mAP@.5:.95精度", f"{targetstr}掩膜mAP@.5:.95精度"])
    plt.savefig(f"{targetstr}_mAP@.5.95精度曲线.jpg")
    plt.clf()

    print(targetstr)
    print((buoy_log_map_box[-1]))
    print((buoy_log_map_mask[-1]))
