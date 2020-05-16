<template>
  <div class="chat">
    <ChatBoard />
  </div>
</template>

<script>
import ChatBoard from "@/components/ChatBoard.vue";

export default {
  name: "Chat",
  components: {
    ChatBoard
  }
};
</script>
