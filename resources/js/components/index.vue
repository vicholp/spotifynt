<template>
  <div
    class="min-h-screen"
    :style="{'background-color': `${backgroundColor ? backgroundColor + '22' : 'white'}`}"
  >
    <v-navbar />
    <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
      <query-index />
    </div>
    <player />
  </div>
</template>
<script>
import { mapState } from 'vuex';

import Player from './layout/player/main.vue';

export default {
  components: {
    Player,
  },
  computed: {
    ...mapState({
      backgroundColor: state => state.player.color,
    }),
  },
  async mounted() {
    if (false) {
      window.addEventListener('beforeunload', e => {
        e.preventDefault();
        e.returnValue = '';
      });
    }
  },
};
</script>
