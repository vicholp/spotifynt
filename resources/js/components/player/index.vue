<template>
  <div class="absolute top-0 left-0 w-full h-full z-10 transition-all">
    <nav
      class="h-20 flex items-center xl:sticky xl:top-0 bg-gray-100 justify-center"
    >
      <div
        class="text-opacity-90 text-3xl font-[Allura]"
        @click="$emit('toggle-overlay')"
      >
        spotifynt
      </div>
    </nav>
    <div class="bg-gray-100 bg-opacity-90 h-full">
      <div class="container mx-auto grid grid-cols-12 gap-3 px-2">
        <div
          class="col-span-12 xl:col-span-4 xl:h-fit xl:sticky xl:top-20 grid grid-cols-12 gap-3 bg-white p-5 dark:bg-opacity-5 rounded"
          @click="$emit('toggle-overlay')"
        >
          <div class="col-span-3 xl:col-span-12">
            <div
              v-if="playerStore.currentTrack.title != null"
              :style="`background-image: url(&quot;${playerStore.currentTrack.release.art['full']}&quot;);`"
              class="bg-cover rounded aspect-1 dark:opacity-90"
            />
            <div
              v-else
              class=" bg-cover rounded shadow aspect-1 bg-gray-300"
            />
          </div>
          <div class="col-span-9 xl:col-span-12 xl:py-10 flex justify-center flex-col items-center">
            <div
              v-if="playerStore.currentTrack.title != null"
              class="text-medium flex-none text-center flex flex-col"
            >
              <div class="text-black font-medium">
                {{ playerStore.currentTrack.title }}
              </div>
              <div class="text-black text-opacity-50 text-sm">
                {{ playerStore.currentTrack.release.title }}
              </div>
            </div>
            <div
              v-else
              class="text-center"
            >
              The playlist is empty
            </div>
            <div :class="`flex items-center mt-5`">
              <button
                class="text-4xl"
                @click.stop="$emit('player-prev')"
              >
                <span
                  class="iconify"
                  data-icon="ic:round-navigate-before"
                />
              </button>
              <button
                class="text-4xl"
                @click.stop="$emit('player-play')"
              >
                <div v-if="playerStore.status.playing">
                  <span
                    class="iconify"
                    data-icon="ic:round-pause"
                  />
                </div>
                <div v-else>
                  <span
                    class="iconify"
                    data-icon="ic:round-play-arrow"
                  />
                </div>
              </button>
              <button
                class="text-4xl"
                @click.stop="$emit('player-next')"
              >
                <span
                  class="iconify"
                  data-icon="ic:round-navigate-next"
                />
              </button>
            </div>
          </div>
        </div>
        <div
          v-if="true"
          class="col-span-12 xl:col-span-8 flex flex-col gap-3 bg-white dark:bg-opacity-5 rounded p-3"
        >
          <div class="flex divide-x divide-white divide-opacity-20 py-3">
            <button
              type="button"
              class="px-3 flex items-center gap-3"
              @click="clearPlaylist()"
            >
              <span
                class="iconify"
                data-icon="mdi:close"
              />
              Clear
            </button>
            <button
              type="button"
              class="px-3 flex items-center gap-3"
              @click="shufflePlaylist()"
            >
              <span
                class="iconify"
                data-icon="ic:round-shuffle"
              />
              Shuffle
            </button>
            <button
              type="button"
              class="px-3 flex items-center gap-3 opacity-50"
            >
              <span
                class="iconify"
                data-icon="mdi:content-save"
              />
              Save
            </button>
          </div>
          <div class="flex flex-col divide-white divide-opacity-30">
            <div
              v-for="(item, i) in playerStore.playlist.tracks"
              :key="i"
              :class="`flex items-center bg-black rounded transition duration-300
                      ${playerStore.playlist.index === i ? 'bg-opacity-5' : 'bg-opacity-0'}`"
            >
              <button
                type="button"
                class="grow text-left bg-opacity-0 bg-black hover:bg-opacity-5 rounded transition duration-300 p-3"
                @click="setPlaylistIndex(i)"
              >
                {{ item.title }}
              </button>
              <div class="flex px-3 py-4 bg-white bg-opacity-0 hover:bg-opacity-5 rounded-r">
                <span
                  class="iconify"
                  data-icon="mdi:close"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import playerStore from '../../store/player';

export default {
  emits: [
    'player-next',
    'player-prev',
    'player-play',
    'toggle-overlay',
  ],
  setup(){
    return {
      playerStore: playerStore(),
    };
  },
  computed: {
    color() {
      return '';
    },
  },
  methods: {
    shufflePlaylist() {
      this.playerStore.playlistShuffle();
    },
    clearPlaylist() {
      this.playerStore.playlistClear();
    },
    setPlaylistIndex(index) {
      this.playerStore.playlistSetIndex(index, false);
    },
  },
};
</script>


