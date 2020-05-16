<template>
  <v-container>
    <v-row class="my-1" align="center">
      <v-col cols="12">
        <div class="display-1">Yolo Playground</div>
      </v-col>
      <v-col cols="12">
        <div class="headline">{{ name }} dataset</div>
      </v-col>
      <v-col cols="12">
        <v-file-input
          v-model="image"
          accept=".png, .jpeg, image/jpeg, image/png"
          solo
          chips
          single-line
          show-size
          @click:append="create"
          @keydown.enter="create"
          label="Image input"
          :loading="sending"
          :disabled="serverdown"
          prepend-icon
          prepend-inner-icon="mdi-image"
          append-icon="mdi-send"
          hide-details="auto"
          :rules="[() => !!image || 'This field is required']"
        ></v-file-input>
      </v-col>
      <template v-for="(image, i) in imagecuts">
        <v-col :key="`${i}-imagecut`" cols="auto">
          <v-lazy transition="scroll-x-transition">
            <v-card>
              <v-img
                max-height="400"
                :src="image.src"
                contain
                class="lightbox white--text align-end grey darken-4"
                gradient="to bottom, rgba(0,0,0,0), rgba(0,0,0,.5)"
              >
                <v-card-title>{{ labels[image.result[5]] }}</v-card-title>
              </v-img>
              <v-card-subtitle>{{ image.result[4] }}</v-card-subtitle>
            </v-card>
          </v-lazy>
        </v-col>
      </template>
      <v-col v-if="image" cols="12">
        <v-lazy transition="scroll-x-transition">
          <v-card>
            <v-img
              max-height="400"
              :src="imageobj.src"
              class="lightbox white--text align-end"
              gradient="to bottom, rgba(0,0,0,0), rgba(0,0,0,.5)"
            >
              <v-card-title>{{ image.name }}</v-card-title>
            </v-img>
            <v-card-subtitle>
              {{ image.lastModifiedDate }} ({{ imageprop.width }}x{{
                imageprop.height
              }})
            </v-card-subtitle>
          </v-card>
        </v-lazy>
      </v-col>
    </v-row>
    <v-snackbar v-model="snackbar.enable" :color="snackbar.color">
      {{ snackbar.text }}
      <v-btn text @click="snackbar.enable = false">Close</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
const axios = require("axios");
export default {
  data: () => ({
    image: null,
    name: "Fetching info for",
    labels: [],
    results: [],
    sending: false,
    imageprop: {
      width: null,
      height: null
    },
    snackbar: {
      enable: false,
      text: "",
      color: "success"
    }
  }),
  watch: {
    image() {
      this.results = [];
    }
  },
  computed: {
    imageobj() {
      if (this.image) {
        var img = new Image();
        img.onload = () => {
          this.imageprop.width = img.naturalWidth;
          this.imageprop.height = img.naturalHeight;
        };
        img.src = URL.createObjectURL(this.image);
        return img;
      } else {
        return null;
      }
    },
    imagecuts() {
      if (this.results && this.results.length) {
        return this.results.map(result => {
          var canvas = document.createElement("canvas");
          var ctx = canvas.getContext("2d");
          canvas.width = result[2];
          canvas.height = result[3];
          ctx.drawImage(
            this.imageobj,
            result[0],
            result[1],
            result[2],
            result[3],
            0,
            0,
            result[2],
            result[3]
          );
          var img = new Image();
          img.src = canvas.toDataURL();
          img.result = result;
          return img;
        });
      } else return null;
    },
    serverdown() {
      if (this.labels.length) {
        return false;
      } else return true;
    }
  },
  methods: {
    create() {
      if (this.image) {
        this.sending = true;
        let formData = new FormData();
        formData.set("image", this.image);
        axios
          .post("/api/yolo", formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(response => {
            this.results = response.data.result;
            this.sending = false;
            console.log(this.results);
            this.snackbar.text = "Your image has been processed. ";
            if (this.results.length) {
              this.snackbar.text +=
                "Found " + this.results.length + " objects.";
              this.snackbar.color = "success";
            } else {
              this.snackbar.text += "No object is found.";
              this.snackbar.color = "error";
            }
            this.snackbar.enable = true;
          })
          .catch(error => {
            console.log(error);
            this.snackbar.text =
              "Your image couldn't be uploaded. Please check your internet";
            this.snackbar.color = "error";
            this.snackbar.enable = true;
          });
      }
    }
  },
  created() {
    this.isActive = false;
    axios
      .get("/api/yolo")
      .then(response => {
        this.labels = response.data.labels;
        this.name = response.data.name;
        this.snackbar.text = "Labels have been loaded.";
        this.snackbar.color = "success";
        this.snackbar.enable = true;
      })
      .catch(error => {
        console.log(error);
        this.snackbar.text =
          "I couldn't connect the server. Please check your internet";
        this.snackbar.color = "error";
        this.snackbar.enable = true;
      });
  }
};
</script>
