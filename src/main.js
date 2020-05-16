import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import vuetify from "./plugins/vuetify";
import Storage from "vue-web-storage";
Vue.config.productionTip = false;

Vue.use(Storage, {
  prefix: "simonsmh_app_",
  drivers: ["local", "session"]
});

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount("#app");
