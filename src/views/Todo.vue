<template>
  <div class="todo">
    <TodoList />
  </div>
</template>

<script>
import TodoList from "@/components/TodoList.vue";

export default {
  name: "Todo",
  components: {
    TodoList
  }
};
</script>
