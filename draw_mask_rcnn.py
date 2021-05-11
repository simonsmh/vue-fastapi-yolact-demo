import os
import json
from matplotlib import rcParams
import matplotlib.pyplot as plt
import numpy as np
import csv

rcParams['font.sans-serif'] = ['SimHei']
rcParams['axes.unicode_minus'] = False


targetstrs = ["50", "101"]
for targetstr in targetstrs:
    buoy_log_map_iter = []
    buoy_log_map_box = []
    buoy_log_map_segm = []
    csvfile_bbox = open(f'eval_results_bbox_{targetstr}.csv', newline='')
    bbox_reader = csv.reader(csvfile_bbox, delimiter=',', quotechar=',')
    for index, row in enumerate(bbox_reader):
        if targetstr == "50":
            buoy_log_map_iter.append(index * 50)
        else:
            buoy_log_map_iter.append(index * 100)
        buoy_log_map_box.append(float(row[0]))

    csvfile_segm = open(f'eval_results_segm_{targetstr}.csv', newline='')
    segm_reader = csv.reader(csvfile_segm, delimiter=',', quotechar=',')
    for index, row in enumerate(segm_reader):
        buoy_log_map_segm.append(float(row[0]))

    plt.title("mAP@.5:.95精度曲线")
    plt.xlabel("迭代")
    plt.ylabel("分数")
    plt.plot(buoy_log_map_iter, buoy_log_map_box)
    plt.plot(buoy_log_map_iter, buoy_log_map_segm)
    plt.legend([f"Mask R-CNN resnet{targetstr}目标框mAP@.5:.95精度",
               f"Mask R-CNN resnet{targetstr}掩膜mAP@.5:.95精度"])
    plt.savefig(f"{targetstr}_mAP@.5.955精度曲线.jpg")
    plt.clf()

    print(targetstr)
    print(max(buoy_log_map_box))
    print(max(buoy_log_map_segm))
