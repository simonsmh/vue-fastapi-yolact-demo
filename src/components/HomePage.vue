<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <div class="display-1">Simon Shi's Apps</div>
      </v-col>
    </v-row>
    <v-item-group>
      <v-row>
        <v-col v-for="(item, index) in items" :key="index" cols="12" md="4">
          <v-item v-slot:default="{ active, toggle }">
            <v-card
              :color="active ? 'primary' : ''"
              class="d-flex align-center"
              @click="toggle"
              hover
              :to="item.to"
            >
              <v-img
                :src="'https://picsum.photos/510/400?random&' + index"
                width="300"
                height="200"
                class="lightbox white--text align-end grey darken-4"
                gradient="to bottom, rgba(0,0,0,0), rgba(0,0,0,.9)"
              >
                <v-card-title>{{ item.text }}</v-card-title>
              </v-img>
            </v-card>
          </v-item>
        </v-col>
      </v-row>
    </v-item-group>
  </v-container>
</template>

<script>
export default {
  name: "Home",
  data: () => ({
    items: [
      { text: "Yolo", to: "/yolo" },
      { text: "Todo", to: "/todo" },
      { text: "Chat", to: "/chat" }
    ]
  })
};
</script>
