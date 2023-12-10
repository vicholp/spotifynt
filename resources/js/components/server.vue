<template>
  <div ref="dot" class="bg-white dark:bg-opacity-5 p-3 rounded flex items-center gap-2 shadow dark:shadow-none">
    <span
      :class="`animate-pulse h-1 w-1 inline-flex rounded-full   mx-2 opacity-75
      ${ serverAvailable == 1 ? 'bg-green-400': 'bg-red-400' }`"
    />
    <p>
      {{ serverStore.activeServer.name }}
    </p>
    <router-link class="ml-auto" to="servers">
      <span class="iconify text-lg" data-icon="mdi:dots-vertical" />
    </router-link>
  </div>
</template>
<script>

import ServerStore from '../store/server';

export default {
  setup() {
    const serverStore = ServerStore();
    return { serverStore };
  },
  data() {
    return {
      serverAvailable: -1,
    };
  },
  mounted() {
    fetch(`${this.serverStore.activeServer.path}`)
      .then(res => {
        if (res.ok) {
          this.serverAvailable = 1;
          return;
        }
        this.serverAvailable = 0;
      });
  },
};
</script>
