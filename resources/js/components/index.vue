<template>
  <div
    class="min-h-screen"
    :style="{'background-color': `${backgroundColor ? backgroundColor + '22' : 'white'}`}"
  >
    <v-navbar />
    <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
      <input
        type="text"
        class="rounded w-full col-span-12 border border-black border-opacity-30"
        placeholder="server"
        v-model="newServerIp"
        @change="setNewServer"
      >
      <query-index />
    </div>
    <player />
  </div>
</template>
<script>
import { mapState } from 'vuex';

import Player from './layout/player/main.vue';

import {
  SERVER_SET_CURRENT_SERVER,
} from '../store/mutation-types.js';

export default {
  components: {
    Player,
  },
  computed: {
    ...mapState({
      backgroundColor: state => state.player.color,
      currentServer: state => state.server.ip,
    }),
  },
  data() {
    return {
      newServerIp: null,
    };
  },
  methods: {
    setNewServer() {
      this.$store.commit({
        type: SERVER_SET_CURRENT_SERVER,
        server: this.newServerIp,
      });
    },
  },
  async mounted() {
    // eslint-disable-next-line no-undef
    if (process.env.APP_ENV === 'production') {
      window.addEventListener('beforeunload', e => {
        e.preventDefault();
        e.returnValue = '';
      });
    }
    this.newServerIp = this.currentServer;
  },
};
</script>
