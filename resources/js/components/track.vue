<template>
  <div
    class="w-full items-center grid grid-cols-12 p-5 rounded bg-white bg-opacity-0 hover:bg-opacity-10 transition duration-300 gap-5 "
    @click="addTrack(track.id)"
  >
    <span class="col-span-5">{{ track.title }}</span>
    <span class="col-span-5">{{ track.release.title }}</span>
    <div class="col-span-2 flex ml-auto">
      <div class="flex rounded">
        <button
          type="button"
          class=""
        >
          <span
            class="iconify text-xl text-gray-500"
            data-icon="ic:round-more-vert"
          />
        </button>
      </div>
    </div>
  </div>
</template>
<script>

import PlayerStore from '../store/player';

export default {
  props: {
    track: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const playerStore = PlayerStore();
    return { playerStore };
  },
  methods: {
    addTrack(trackId) {
      this.playerStore.playlistAddTrackById(trackId);
    },
  },
};
</script>
