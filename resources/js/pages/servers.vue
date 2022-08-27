<template>
  <layout>
    <div class="container mx-auto flex flex-col gap-3  px-2">
      <div class="bg-white dark:bg-opacity-5 p-3 rounded flex flex-col gap-3">
        <h2>New server</h2>
        <div class="flex gap-2">
          <input v-model="serverName" type="text" class="focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-opacity-5 flex-1 block w-full rounded border-gray-300">
          <button
            class="bg-white dark:bg-opacity-20 rounded p-2 px-4"
            @click="addServer"
          >
            Add
          </button>
        </div>
      </div>
      <div class="bg-white dark:bg-opacity-5 p-3 rounded">
        <h2>Servers</h2>
        <div class="flex flex-col">
          <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
              <div class="overflow-hidden">
                <table class="min-w-full">
                  <thead class="border-b">
                    <tr>
                      <th scope="col" class="text-sm font-medium px-6 py-4 text-left">
                        #
                      </th>
                      <th scope="col" class="text-sm font-medium px-6 py-4 text-left">
                        Name
                      </th>
                      <th scope="col" class="text-sm font-medium px-6 py-4 text-left">
                        Path
                      </th>
                      <th scope="col" class="text-sm font-medium px-6 py-4 text-left">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="server in servers"
                      :key="server.id"
                      class="border-b"
                    >
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        {{ server.id }}
                      </td>
                      <td class="text-sm px-6 py-4 whitespace-nowrap">
                        {{ server.name }}
                      </td>
                      <td class="text-sm px-6 py-4 whitespace-nowrap">
                        {{ server.path }}
                      </td>
                      <td class="text-sm px-6 py-4 whitespace-nowrap">
                        <button
                          v-if="server.id != serverStore.activeServer.id"
                          type="button"
                          @click="setActiveServer(server)"
                        >
                          enable
                        </button>
                        <div
                          v-else
                        >
                          active
                        </div>
                        <router-link :to="`server/${server.id}`">
                          view
                        </router-link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>

import Layout from '../layouts/main.vue';
import UserServerApi from '../api/userServer';
import ServerStore from '../store/server';
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
