<template>
  <nav
    :class="`p-5 shadow ${backgroundColor === false ? 'bg-gray-100' : ''}`"
    :style="{
      'background-color': `${backgroundColor}33`,
      'border-color': `${backgroundColor}`
    }"
  >
    <div class="flex">
      <a class="" href="/">Home</a>
      <button class="" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""></span>
      </button>
      <div class="flex flex-row justify-around">
        <a class="ml-4" href="/spotifynt">Spotifynt</a>
      </div>
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
