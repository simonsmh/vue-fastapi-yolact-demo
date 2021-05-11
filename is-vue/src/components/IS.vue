<template>
  <el-container>
    <el-header>
      航标检测 APP -
      <el-dropdown class="dd" @command="handleCommand">
        <span class="el-dropdown-link">
          当前模型：{{ dd_cur[0]
          }}<i class="el-icon-arrow-down el-icon--right"></i>
        </span>
        <template #dropdown>
          <el-dropdown-menu>
            <el-dropdown-item command="rcnn">Mask R-CNN</el-dropdown-item>
            <el-dropdown-item command="yolact">YOLACT</el-dropdown-item>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </el-header>
    <el-main>
      <el-row type="flex" justify="center" align="middle" :gutter="10">
        <el-col id="upload_col">
          <el-upload
            class="upload-demo"
            :action="dd_cur[1]"
            drag
            multiple
            :on-preview="handlePreview"
            :on-remove="handleRemove"
            :on-success="handleSuccess"
            :before-remove="beforeRemove"
            :on-exceed="handleExceed"
            :file-list="fileList"
            list-type="picture"
          >
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">
              将文件拖到此处，或<em>点击上传</em>
            </div>
            <template #tip>
              <div class="el-upload__tip">只能上传 jpg/png 文件</div>
            </template>
          </el-upload>
        </el-col>
      </el-row>
      <el-row type="flex" justify="center" align="middle">
        <el-col id="image_col">
          <el-card :body-style="{ padding: '0px' }">
            <el-image
              class="demo-image"
              :preview-src-list="[url]"
              :src="url"
              fit="cover"
            >
              <template #error>
                <div class="image-slot">
                  <i class="el-icon-picture-outline"></i>
                </div>
              </template>
            </el-image>
            <div style="padding: 14px">
              <span>{{ name }}</span>
              <div class="bottom">
                <time class="time">{{ time }}</time>
              </div>
            </div>
          </el-card>
        </el-col>
      </el-row>
    </el-main>
    <el-footer>Simon Shi &copy; {{ new Date().getFullYear() }}</el-footer>
  </el-container>
</template>

<script setup>
</script>

<script>
export default {
  data() {
    var dd_data = [
      ["YOLACT", "http://localhost:8000/yolact"],
      ["Mask R-CNN", "http://localhost:8000/rcnn"],
    ];
    return {
      fileList: [],
      dd_data: dd_data,
      dd_cur: dd_data[0],
      dd_text: "YOLACT",
      gateway: "http://localhost:8000/yolact",
      url: "",
      name: "未知图片",
      time: new Date().toDateString(),
    };
  },
  methods: {
    handleCommand(command) {
      if (command === "rcnn") {
        this.dd_cur = this.dd_data[1];
      } else if (command === "yolact") {
        this.dd_cur = this.dd_data[0];
      } else {
        this.dd_cur = this.dd_data[0];
      }
    },
    handleRemove(file, fileList) {
      this.url = "";
      this.name = "未知图片";
      this.time = new Date().toDateString();
      console.log(file, fileList);
    },
    handlePreview(file) {
      console.log(file);
      this.url = file.selfurl;
      this.name = file.name;
      this.time = file.time;
    },
    handleSuccess(response, file, fileList) {
      console.log(file, response, fileList);
      file.selfurl = "data:text/plain;base64," + response.img;
      file.time = response.time + "秒";
      this.url = file.selfurl;
      this.name = file.name;
      this.time = file.time;
    },
    handleExceed(files, fileList) {
      this.$message.warning(
        `当前限制选择 1 个文件，本次选择了 ${files.length} 个文件，共选择了 ${
          files.length + fileList.length
        } 个文件`
      );
    },
    beforeRemove(file, fileList) {
      return this.$confirm(`确定移除 ${file.name}？`);
    },
  },
};
</script>

<style>
.el-header {
  color: #000000;
  background-color: rgb(240, 240, 240);
  text-align: center;
  line-height: 60px;
}
.el-footer {
  color: #000000;
  background-color: rgb(240, 240, 240);
  text-align: center;
  line-height: 60px;
}
.el-row {
  margin-bottom: 20px;
}
#upload_col {
  display: flex;
  justify-content: center;
}
#image_col {
  display: flex;
  flex: auto;
  justify-content: center;
}
.demo-image {
  width: 400px;
  height: 240px;
}
.image-slot {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 400px;
  height: 240px;
  background: #f5f7fa;
  color: #909399;
  font-size: 80px;
}
.time {
  font-size: 13px;
  color: #999;
}
.bottom {
  margin-top: 13px;
  line-height: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.el-dropdown {
  color: #000000;
  background-color: rgb(240, 240, 240);
  text-align: center;
}
</style>