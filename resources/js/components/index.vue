<template>
  <div
    :style="{'background-color': `${backgroundColor}22`}"
    class="bg-opacity-50"
  >
    <div>
      <v-navbar />
      <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
        <query-index />
      </div>
      <player />
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';

import Player from './layout/player.vue';

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
