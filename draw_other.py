import os
import json
from matplotlib import rcParams
import matplotlib.pyplot as plt
import numpy as np
import csv

rcParams['font.sans-serif'] = ['SimHei']
rcParams['axes.unicode_minus'] = False


targetstrs = ["yolact_resnet50", "yolact_resnet101",
              "rcnn_resnet50", "rcnn_resnet101"]

lens = np.arange(len(targetstrs))

plt.title("mAP@.5:.95精度对比")
plt.xlabel("种类")
plt.ylabel("分数")
plt.bar(2*lens-0.25, [92.28, 92.39, 91.4673, 91.8659],
        label="目标框mAP@.5:.95精度", width=0.5)
plt.bar(2*lens+0.25, [86.15, 85.62, 86.417, 87.0078],
        label="掩膜mAP@.5:.95精度", width=0.5)
plt.xticks(2*lens, targetstrs)
plt.legend(["目标框mAP@.5:.95精度", "掩膜mAP@.5:.95精度"])
plt.axis([-1, 7, 80, 95])
plt.savefig(f"mAP@.5.95精度对比.jpg")
plt.clf()

targetstrs = ["yolact_resnet50", "yolact_resnet101",
              "rcnn_resnet50", "rcnn_resnet101"]

lens = np.arange(len(targetstrs))

plt.title("实例分割模型速度对比")
plt.xlabel("种类")
plt.ylabel("帧/秒")
plt.bar(2*lens-0.5, [32, 21, 8, 2],
        label="RTX2070", width=0.5)
plt.bar(2*lens, [17, 14, 2, 1],
        label="GTX1050", width=0.5)
plt.bar(2*lens+0.5, [8, 4, 0, 0],
        label="Jetson Nano", width=0.5)
plt.xticks(2*lens, targetstrs)
plt.legend(["NVIDIA RTX2070", "NVIDIA GTX1050", "NVIDIA Jetson Nano"])
plt.savefig(f"实例分割模型速度.jpg")
plt.clf()
