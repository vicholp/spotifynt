<template>
  <div
    class="col-span-12 grid grid-cols-12 gap-3"
  >
    <div
      class="col-span-12 grid grid-cols-12 gap-3"
    >
      <Album
        v-for="album in results.albums"
        :key="album.id"
        :album="album"
      />
    </div>
    <div class="col-span-12 bg-white bg-opacity-10 rounded shadow flex flex-col divide-y p-3">
      <sp-track
        v-for="track in results.tracks"
        :key="track.id"
        :track="track"
      />
    </div>
  </div>
</template>
<script>

import Album from '../album';
import SpTrack from '../track.vue';

export default {
  components: {
    Album,
    SpTrack,
  },
  props: {
    results: {
      type: Object,
      required: true,
    },
  },
};
</script>
