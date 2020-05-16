<template>
  <v-container>
    <v-row class="my-1" align="center">
      <v-col cols="6" align="left">
        <div class="display-1 success--text">
          Tasks: {{ allTasks }}
          <span></span>
        </div>
      </v-col>
      <v-col cols="6" align="right">
        <v-progress-circular
          :value="progress"
          color="green"
        ></v-progress-circular>
      </v-col>
      <v-col cols="12">
        <v-text-field
          v-model="tasktext"
          label="What are you working on?"
          solo
          append-icon="mdi-send"
          @click:append="create"
          @keydown.enter="create"
          clearable
          hide-details="auto"
          :rules="[taskRules.required]"
        ></v-text-field>
        <v-spacer></v-spacer>
      </v-col>
      <v-col cols="12" align="right">
        <v-divider></v-divider>
      </v-col>
      <v-col cols="6" align="left">
        <div class="info--text">Remaining: {{ remainingTasks }}</div>
      </v-col>
      <v-col cols="6" align="right">
        <div class="success--text">Completed: {{ completedTasks }}</div>
      </v-col>
    </v-row>
    <v-divider class="mb-4"></v-divider>
    <v-card v-if="allTasks" hover>
      <template v-for="(task, i) in tasks">
        <v-lazy :key="`${i}-divider`" transition="scroll-x-transition">
          <v-divider v-if="i !== 0 && task.show"></v-divider>
        </v-lazy>
        <v-lazy :key="`${i}-lazy`" transition="scroll-x-transition">
          <v-list-item v-if="task.show">
            <v-list-item-action>
              <v-checkbox
                v-model="task.done"
                :color="(task.done && 'grey') || 'primary'"
              >
                <template v-slot:label>
                  <div
                    :class="(task.done && 'grey--text') || 'primary--text'"
                    class="ml-4"
                    v-text="task.text"
                  ></div>
                </template>
              </v-checkbox>
            </v-list-item-action>
            <v-spacer></v-spacer>
            <v-scroll-x-transition>
              <v-icon v-if="task.done" color="success">mdi-check</v-icon>
            </v-scroll-x-transition>
            <v-btn icon color="grey" v-on:click="del(i)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </v-list-item>
        </v-lazy>
      </template>
    </v-card>
    <v-snackbar v-model="snackbar.enable" :color="snackbar.color">
      {{ snackbar.text }}
      <v-btn text v-if="snackbar.create" @click="snackbar.enable = false"
        >Close</v-btn
      >
      <v-btn
        text
        v-else
        @click="
          snackbar.enable = false;
          tasks[lasttask].show = true;
        "
        >Undo</v-btn
      >
    </v-snackbar>
  </v-container>
</template>

<script>
import Vue from "vue";
function getTasks() {
  return Vue.$localStorage
    .get("tasks", [
      {
        show: true,
        done: false,
        text: "Study"
      },
      {
        show: true,
        done: true,
        text: "Sleep"
      }
    ])
    .filter(task => task.show);
}

export default {
  data: () => ({
    tasks: getTasks(),
    tasktext: null,
    lasttask: 0,
    snackbar: {
      enable: false,
      text: "",
      color: "success",
      create: true
    },
    taskRules: {
      required: value => !!value || "Required."
    }
  }),

  computed: {
    allTasks() {
      return this.tasks.filter(task => task.show).length;
    },
    completedTasks() {
      return this.tasks.filter(task => task.show && task.done).length;
    },
    remainingTasks() {
      return this.allTasks - this.completedTasks;
    },
    progress() {
      Vue.$localStorage.set("tasks", this.tasks);
      return (this.completedTasks / this.allTasks) * 100;
    }
  },

  methods: {
    create() {
      if (this.tasktext) {
        this.lasttask = this.tasks.length;
        this.tasks.push({
          show: true,
          done: false,
          text: this.tasktext
        });
        this.tasktext = null;
        Vue.$localStorage.set("tasks", this.tasks);
        this.snackbar.text = "Your tasks has been created.";
        this.snackbar.create = true;
        this.snackbar.enable = true;
      }
    },
    del(num) {
      this.lasttask = num;
      this.tasks[num].show = false;
      Vue.$localStorage.set("tasks", this.tasks);
      this.snackbar.text = "Your tasks has been deleted.";
      this.snackbar.create = false;
      this.snackbar.enable = true;
    }
  }
};
</script>
