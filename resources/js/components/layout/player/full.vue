<template>
  <div
    class="h-full w-full"
  >
    <div
      class="bg-cover brightness-50 bg-center"
    />
    <div
      class="absolute top-0 z-10 w-full h-full flex p-3 bg-gray-100"
      :style="{'background-color': `${color ? color : 'white'}`}"
    >
      <div class="container mx-auto flex flex-col gap-3">
        <div class="grid grid-cols-12 gap-3 bg-white shadow-lg rounded bg-opacity-40">
          <div class="col-span-3">
            <div
              v-if="loaded"
              :style="{'background-image':`url(${getArtFromAlbum(currentServerIp, this.actual.album.beetsId)})`}"
              @click="$emit('go-mini')"
              class=" bg-cover rounded-l shadow aspect-square"
            />
            <div
              v-else
              class=" bg-cover rounded-l shadow aspect-square bg-gray-300"
              @click="$emit('go-mini')"
            />
          </div>
          <div class="col-span-9 flex justify-center flex-col items-center">
            <div
              v-if="loaded"
              class="text-medium flex-none text-center"
            >
              {{ actual.name }} - {{ actual.artist.name }}
            </div>
            <div
              v-else
              class="text-center"
            >
              The playlist is empty
            </div>
            <div :class="`flex items-center mt-5 ${loaded ? 'opacity-100' : 'opacity-30'}`">
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
                <div v-if="status.playing">
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
          v-if="loaded"
          class="flex flex-col gap-3 bg-white shadow rounded bg-opacity-40 p-3 text-black text-opacity-90"
        >
          <div class="flex divide-x divide-white divide-opacity-30 pt-3 pl-3 ">
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
              v-for="(item, i) in playlist.tracks"
              :key="i"
              :class="`flex items-center gap-3 bg-white pr-3 rounded
                      ${playlist.index === i ? 'bg-opacity-20' : 'bg-opacity-0'}`"
            >
              <button
                type="button"
                class="grow text-left  bg-opacity-0 bg-white hover:bg-opacity-10 rounded transition duration-100 py-3 pl-3"
                @click="setPlaylistIndex(i)"
              >
                {{ item.name }}
              </button>
              <div class="my-3 flex justify-center">
                <button>
                  <span
                    class="iconify"
                    data-icon="mdi:close"
                  />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';

import {
  PLAYER_SET_INDEX,
  PLAYER_PLAYLIST_SHUFFLE,
} from '../../../store/action-types.js';

import {
  PLAYER_PLAYLIST_CLEAR,
} from '../../../store/mutation-types.js';

import getArtFromAlbum from '../../../helpers/getArtFromAlbum.js';

export default {
  props: {
    progress: {
      type: Number,
      required: true,
    },
    actual: {
      type: Object,
      required: true,
    },
    loaded: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    ...mapState({
      status: state => state.player.status,
      color: state => state.player.color,
      playlist: state => state.player.playlist,
      currentServerIp: state => state.server.ip,
    }),
  },
  methods: {
    getArtFromAlbum,
    setPlaylistIndex(i) {
      this.$store.dispatch({
        type: PLAYER_SET_INDEX,
        index: i,
        relative: false,
      });
    },
    clearPlaylist() {
      this.$store.commit({
        type: PLAYER_PLAYLIST_CLEAR,
      });
    },
    shufflePlaylist() {
      this.$store.dispatch({
        type: PLAYER_PLAYLIST_SHUFFLE,
      });
    },
  },
};
</script>
