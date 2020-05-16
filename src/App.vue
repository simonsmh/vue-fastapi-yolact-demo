<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list nav>
        <v-list-item-avatar>
          <v-img
            src="https://secure.gravatar.com/avatar/890af63a269b54d85f79ee351c4d48c4"
          ></v-img>
        </v-list-item-avatar>
        <v-list-item href="mailto:simonsmh@gmail.com" link>
          <v-list-item-content>
            <v-list-item-title class="title">Simon Shi</v-list-item-title>
            <v-list-item-subtitle>simonsmh@gmail.com</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-divider class="mt-1"></v-divider>
      <v-list nav dense shaped>
        <v-subheader>App links</v-subheader>
        <v-list-item-group color="primary">
          <template v-for="item in items">
            <v-list-item :key="item.text" v-if="item.to" :to="item.to" link>
              <v-list-item-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{ item.text }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-list-item-group>
      </v-list>
      <v-divider class="mt-1"></v-divider>
      <v-list nav dense shaped>
        <v-subheader>Other links</v-subheader>
        <v-list-item-group color="primary">
          <template v-for="item in items">
            <v-list-item
              :key="item.text"
              v-if="item.href"
              :href="item.href"
              link
            >
              <v-list-item-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{ item.text }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title class="ml-0 pl-4">
        <span>Simon Shi's Apps</span>
      </v-toolbar-title>
    </v-app-bar>

    <v-content>
      <router-view></router-view>
    </v-content>

    <v-footer absolute inset app>
      <div>Simon Shi &copy; {{ new Date().getFullYear() }}</div>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    dialog: false,
    drawer: null,
    items: [
      { icon: "mdi-home", text: "Home", to: "/" },
      { icon: "mdi-image", text: "Yolo", to: "/yolo" },
      { icon: "mdi-clipboard-check", text: "Todo", to: "/todo" },
      { icon: "mdi-forum", text: "Chat", to: "/chat" },
      { icon: "mdi-account-circle", text: "Blog", href: "https://simonsmh.cc" }
    ]
  })
};
</script>
