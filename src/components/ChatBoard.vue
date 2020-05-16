<template>
  <v-container>
    <v-row align="center" justify="center" dense>
      <v-col cols="12">
        <div class="display-1 px-4">Chat Board</div>
      </v-col>
      <v-col cols="12">
        <div class="headline px-4">Let's talking here~</div>
      </v-col>
    </v-row>
    <v-lazy v-model="isActive">
      <v-row align="center">
        <v-col
          align="center"
          cols="sm-6 md-4"
          v-for="(chat, index) in chats"
          :key="index"
        >
          <v-card align="left" class="ma-4 pa-4" hover>
            <v-card-title>{{ chat.name }}</v-card-title>
            <v-card-subtitle>
              {{ chat.email }} via {{ chat.ip }}
              <br />
              {{ chat.time }}
            </v-card-subtitle>
            <v-card-text>
              <div>{{ chat.text }}</div>
            </v-card-text>
            <v-card-actions v-if="chat.ip == ip">
              <v-btn
                v-on:click="del(chat.uid)"
                text
                color="deep-purple accent-4"
                >Delete</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-lazy>
    <v-lazy>
      <v-fab-transition>
        <v-btn
          v-show="!fabshow"
          class="mx-2"
          fixed
          fab
          dark
          bottom
          right
          color="indigo"
          transition="slide-x-transition"
          @click.stop="newdialog = true"
        >
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-fab-transition>
    </v-lazy>

    <v-dialog v-model="newdialog" max-width="600">
      <v-card>
        <v-sheet class="px-8 py-4">
          <v-form ref="form" v-model="valid">
            <v-text-field
              v-model="name"
              :counter="10"
              :rules="nameRules"
              label="Name"
              required
            ></v-text-field>
            <v-text-field
              v-model="email"
              :rules="emailRules"
              label="E-mail"
              required
            ></v-text-field>
            <v-textarea
              v-model="text"
              :counter="233"
              :rules="textRules"
              label="Words"
              :hint="'Your ip is ' + ip + ' which could be tracked.'"
              required
            ></v-textarea>
            <v-btn
              :disabled="!valid"
              color="success"
              class="mr-4"
              v-on:click="validate"
              text
              >Send</v-btn
            >
            <v-btn color="error" class="mr-4" v-on:click="reset" text
              >Reset Form</v-btn
            >
          </v-form>
        </v-sheet>
      </v-card>
    </v-dialog>
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
    newdialog: false,
    snackbar: {
      enable: false,
      text: "",
      color: "success"
    },
    fabshow: false,
    valid: true,
    name: "",
    nameRules: [
      v => !!v || "Name is required",
      v => (v && v.length <= 10) || "Name must be less than 10 characters"
    ],
    email: "",
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    ],
    text: "",
    textRules: [
      v => !!v || "Text is required",
      v => (v && v.length <= 233) || "Text must be less than 233 characters"
    ],
    ip: "<fetching...>",
    chats: []
  }),
  methods: {
    validate() {
      this.$refs.form.validate();
      this.newdialog = false;
      axios
        .put("/api/chatboard", {
          name: this.name,
          email: this.email,
          text: this.text
        })
        .then(response => {
          this.chats = response.data.user;
          this.snackbar.text = "Your words has been sent.";
          this.snackbar.color = "success";
          this.snackbar.enable = true;
        })
        .catch(error => {
          console.log(error);
          this.snackbar.text = "Your words has not been sent.";
          this.snackbar.color = "error";
          this.snackbar.enable = true;
        });
      this.$refs.form.reset();
    },
    reset() {
      this.$refs.form.reset();
    },
    del(uid) {
      console.log(uid);
      axios
        .delete("/api/chatboard/" + uid)
        .then(response => {
          this.chats = response.data.user;
          this.snackbar.text = "Your words has been deleted.";
          this.snackbar.color = "success";
          this.snackbar.enable = true;
        })
        .catch(error => {
          console.log(error);
          this.snackbar.text = "Your words has not been deleted.";
          this.snackbar.color = "error";
          this.snackbar.enable = true;
        });
    }
  },
  created() {
    this.isActive = false;
    axios.get("/api/chatboard/all").then(response => {
      this.chats = response.data.user;
    });
  },
  mounted() {
    axios.get("/api/ip").then(response => {
      this.ip = response.data.client_host;
    });
    this.timer = setInterval(function() {
      axios.get("/api/chatboard/all").then(response => {
        this.chats = response.data.user;
      });
    }, 10000);
  },
  beforeDestroy() {
    clearInterval(this.timer);
  }
};
</script>
