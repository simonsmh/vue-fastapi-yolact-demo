import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import(/* webpackChunkName: "home" */ "../views/Home.vue")
  },
  {
    path: "/chat",
    name: "Chat",
    component: () => import(/* webpackChunkName: "chat" */ "../views/Chat.vue")
  },
  {
    path: "/todo",
    name: "Todo",
    component: () => import(/* webpackChunkName: "todo" */ "../views/Todo.vue")
  },
  {
    path: "/yolo",
    name: "Yolo",
    component: () => import(/* webpackChunkName: "yolo" */ "../views/Yolo.vue")
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
