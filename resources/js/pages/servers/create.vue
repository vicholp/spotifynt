<template>
  <layout>
    <div class="container mx-auto flex flex-col gap-3  px-2">
      <div class="bg-white dark:bg-opacity-5 p-3 rounded flex flex-col gap-3">
        <form class="flex flex-col gap-3">
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-3">
              Name
            </div>
            <input
              v-model="serverName"
              type="text"
              name="name"
              placeholder="User's name"
              class="col-span-9 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-opacity-5 flex-1 block w-full rounded border-none"
            >
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-3">
              Path
            </div>
            <input
              v-model="serverPath"
              type="text"
              name="name"
              placeholder="https://example.com"
              class="col-span-9 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-opacity-5 flex-1 block w-full rounded border-none"
            >
          </div>
        </form>
      </div>
      <div class="bg-white dark:bg-opacity-5 p-3 rounded flex flex-col gap-3">
        <div class="flex w-full">
          <button
            class="bg-white w-full dark:bg-opacity-10 rounded p-2 px-4"
            @click="submit"
          >
            Create new server
          </button>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>

import Layout from '../../layouts/main.vue';
import ServerApi from '../../api/server';

export default {
  components: {
    Layout,
  },
  props: {
    authUser: {
      default: () => {},
      type: Object,
    },
  },
  methods: {
    submit() {
      ServerApi.store({
        'name': this.serverName,
        'path': this.serverPath,
      }).then((response) => {
        console.log(response);
      });
    },
  },
};
</script>
