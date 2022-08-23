<template>
  <navbar />
  <slot />
  <Player />
</template>
<script>
import Navbar from './navbar.vue';
import Player from '../components/player';

export default {
  components: {
    Navbar,
    Player,
  },
};
</script>
