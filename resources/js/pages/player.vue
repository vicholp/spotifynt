<template>
  <layout>
    <div class="container mx-auto flex flex-col gap-3  px-2">
      <div class="grid grid-cols-12 gap-3 bg-white dark:bg-opacity-5 rounded">
        <div class="col-span-3">
          <div
            v-if="playerStore.currentTrack.title != null"
            :style="`background-image: url(&quot;http://vicholp.duckdns.org:9000/album/${Math.floor(Math.random()*100)}/art&quot;);`"
            class="bg-cover rounded-l aspect-square dark:opacity-90"
          />
          <div
            v-else
            class=" bg-cover rounded-l shadow aspect-square bg-gray-300"
          />
        </div>
        <div class="col-span-9 flex justify-center flex-col items-center">
          <div
            v-if="playerStore.currentTrack.title != null"
            class="text-medium flex-none text-center"
          >
            {{ playerStore.currentTrack.title }}
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
              @click="$emit('previus-track')"
            >
              <span
                class="iconify"
                data-icon="ic:round-navigate-before"
              />
            </button>
            <button
              class="text-4xl"
              @click="$emit('play-pause')"
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
              @click="$emit('next-track')"
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
        class="flex flex-col gap-3 bg-white dark:bg-opacity-5 rounded p-3"
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
            :class="`flex items-center bg-white rounded
                      ${playerStore.playlist.index === i ? 'bg-opacity-10' : 'bg-opacity-0'}`"
          >
            <button
              type="button"
              class="grow text-left bg-opacity-0 bg-white hover:bg-opacity-5 rounded transition duration-300 p-3"
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
  </layout>
</template>
<script>

import Layout from '../layouts/main';

import playerStore from '../store/player';

export default {
  components: {
    Layout,
  },
  emits: [
    'player-next',
    'player-prev',
    'player-play',
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
