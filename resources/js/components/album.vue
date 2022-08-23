<template>
  <div
    class="rounded aspect-square w-full bg-black bg-opacity-70 hover:bg-opacity-100 transition duration-300 relative col-span-6 md:col-span-4 lg:col-span-3 xl:col-span-2"
    @click="addAlbum(album.id)"
  >
    <div
      style="background-image: url(&quot;http://vicholp.duckdns.org:9000/album/60/art&quot;);"
      class="opacity-50 h-full w-full bg-cover rounded shadow"
    />
    <div class="flex items-center absolute top-0 flex-col h-full w-full text-white justify-around px-5">
      <span class="text-center font-bold text-opacity-90">{{ album.title }}</span>
      <span class="text-sm text-opacity-70">{{ album.id }}</span>
    </div>
  </div>
</template>
<script>

import PlayerStore from '../store/player';

export default {
  props: {
    album: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const playerStore = PlayerStore();
    return { playerStore };
  },
  methods: {
    addAlbum(albumId) {
      this.playerStore.playlistAddAlbum(albumId);
    },
  },
};
</script>
