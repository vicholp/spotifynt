<template>
  <nav
    :class="`p-5 shadow ${backgroundColor === false ? 'bg-gray-100' : ''}`"
    :style="{
      'background-color': `${backgroundColor ? backgroundColor + '33' : 'white'}`,
      'border-color': `${backgroundColor ? backgroundColor : 'white'}`
    }"
  >
    <div class="flex">
      <a
        class=""
        href="/"
      >
        Spotifynt
      </a>
    </div>
  </nav>
</template>
<script>
import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState({
      backgroundColor: state => state.player.color,
    }),
  },
};
</script>
