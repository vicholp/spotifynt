<template>
  <div
    class="rounded aspect-square w-full bg-black bg-opacity-90 transition duration-300 relative col-span-6 md:col-span-4 lg:col-span-3 xl:col-span-2 shadow dark:shadow-none"
    @click="addAlbum(album.id)"
  >
    <div
      :style="`background-image: url(&quot;${album.art[250]}&quot;);`"
      class="opacity-90 h-full w-full bg-cover rounded hover:opacity-100 transition duration-300"
    />
    <div class="flex flex-row items-end absolute top-0 h-full w-full text-white justify-around hover:text-opacity-90 text-opacity-0 pointer-events-none transition duration-300">
      <div class="flex flex-col w-full items-center gap-3 pointer-events-auto p-5">
        <RouterLink class="text-sm" :to="`/album/${album.id}`">
          <span class="text-center font-bold">{{ album.title }}</span>
        </RouterLink>
      </div>
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
