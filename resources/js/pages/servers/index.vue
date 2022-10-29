<template>
  <layout>
    <div class="container mx-auto flex flex-col gap-3  px-2">
      <div class="bg-white dark:bg-opacity-5 p-3 rounded flex flex-col gap-3">
        <div class="p-1">
          <h2>Add server</h2>
        </div>
        <div class="flex gap-2">
          <input
            v-model="serverName"
            type="text"
            class="focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-opacity-5 flex-1 block w-full rounded border-none"
          >
          <button
            class="bg-white dark:bg-opacity-10 rounded p-2 px-4"
            @click="addServer"
          >
            Add
          </button>
        </div>
      </div>
      <div class="bg-white dark:bg-opacity-5 p-3 rounded flex flex-col gap-3">
        <div class="flex w-full">
          <router-link
            :to="`servers/create`"
            class="bg-white w-full dark:bg-opacity-10 rounded p-2 px-4"
          >
            Create new server
          </router-link>
        </div>
      </div>
      <div class="bg-white dark:bg-opacity-5 p-3 rounded">
        <div class="flex justify-between items-center p-1">
          <h2>Servers</h2>
        </div>
        <div class="flex flex-col pt-3">
          <div
            v-for="server in servers"
            :key="server.id"
            class="grid grid-cols-12 p-2 items-center"
          >
            <div class="col-span-3">
              {{ server.name }}
            </div>
            <div class="col-span-3">
              {{ server.owner.name }}
            </div>
            <div class="col-span-3" />
            <div class="col-span-3 flex gap-3 justify-end">
              <button
                v-if="server.id != serverStore.activeServer.id"
                type="button"
                class="p-2 rounded bg-white dark:bg-opacity-10"
                @click="setActiveServer(server)"
              >
                enable
              </button>
              <div
                v-else
                class="p-2 rounded bg-white dark:bg-opacity-5"
              >
                active
              </div>
              <router-link
                class="p-2 rounded bg-white dark:bg-opacity-10"
              >
                view
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>

import Layout from '../../layouts/main.vue';
import UserServerApi from '../../api/userServer';
import ServerStore from '../../store/server';
import { mapWritableState } from 'pinia';

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
  setup() {
    const serverStore = ServerStore();
    return { serverStore };
  },
  data() {
    return {
      servers: [],
      serverName: "",
    };
  },
  computed: {
    ...mapWritableState(ServerStore, ['activeServer']),
  },
  async mounted() {
    this.getServers();
  },
  methods: {
    async getServers() {
      this.servers = (await UserServerApi.index(this.authUser.id)).data.data;
    },
    addServer() {
      UserServerApi.store(this.serverName, this.authUser.id);
      this.serverName = "";
      this.getServers();
    },
    setActiveServer(server) {
      this.activeServer = server;
    },
  },
};
</script>
