<template>
  <div class="col-span-12 grid grid-cols-12 gap-3">
    <div class="col-span-12 bg-white rounded shadow p-3 bg-opacity-20 ">
      <input
        type="text"
        class="rounded w-full border border-black border-opacity-30"
        v-model="query"
        placeholder="search"
        @input="sendQuery"
      >
    </div>
    <div
      v-if="this.queryResults !== false"
      class="col-span-12 grid grid-cols-12 gap-3"
    >
      <div class="col-span-12 ">
        <transition-group
          name="fade"
          class="grid grid-cols-12 gap-3"
        >
          <div
            v-for="album in queryResults.albums"
            :key="album.id"
            class=" rounded aspect-square w-full bg-black bg-opacity-70 hover:bg-opacity-100 transition duration-300 relative col-span-6 md:col-span-4 lg:col-span-3 xl:col-span-2"
            @click="addAlbum(album.id)"
          >
            <div
              :style="{'background-image':`url(${currentServerIp}/album/${album.beetsId}/art)`}"
              class="opacity-50 h-full w-full bg-cover rounded shadow"
            />
            <div class="flex items-center absolute top-0 flex-col h-full w-full text-white justify-around px-5">
              <span class="text-center font-bold text-opacity-90">{{ album.name }}</span>
              <span class="text-sm text-opacity-70">{{ album.artist.name }}</span>
            </div>
          </div>
        </transition-group>
      </div>
      <div class="col-span-12 bg-white bg-opacity-20 rounded shadow flex flex-col divide-y p-3">
        <div
          v-for="(track, i) in queryResults.tracks"
          :key="track.id"
          class="w-full items-center grid grid-cols-12 p-4 bg-white bg-opacity-0 hover:bg-opacity-10 transition duration-300 gap-5"
          @click="addTrack(i)"
        >
          <span class="col-span-5">{{ track.name | truncate(25) }}</span>
          <span class="col-span-5">{{ track.album.name }}</span>
          <div class="col-span-2 flex ml-auto">
            <div class="flex bg-white bg-opacity-10 rounded">
              <button
                type="button"
                class="p-2"
              >
                <span
                  class="iconify text-xl"
                  data-icon="ic:outline-play-arrow"
                />
              </button>
              <button
                type="button"
                class="p-2"
              >
                <span
                  class="iconify text-xl text-gray-500"
                  data-icon="ic:round-more-vert"
                />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-else
      class="col-span-12"
    >
      <h2
        class="text-2xl my-4 text-black text-opacity-90"
      >
        Random albums
      </h2>
      <transition-group
        name="fade"
        class="grid grid-cols-12 gap-3"
      >
        <div
          v-for="album in recommendations.albums"
          :key="album.id"
          class=" rounded aspect-square w-full bg-black bg-opacity-70 hover:bg-opacity-100 transition duration-300 relative col-span-6 md:col-span-4 lg:col-span-3 xl:col-span-2"
          @click="addAlbum(album.id)"
        >
          <div
            :style="{'background-image':`url(${currentServerIp}/album/${album.beetsId}/art)`}"
            class="opacity-50 h-full w-full bg-cover rounded shadow"
          />
          <div class="flex items-center absolute top-0 flex-col h-full w-full text-white justify-around px-5">
            <span class="text-center font-bold text-opacity-90">{{ album.name }}</span>
            <span class="text-sm text-opacity-70">{{ album.artist.name }}</span>
          </div>
        </div>
      </transition-group>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';

import MainApi from '../../api/main.js';
import RecommendationsApi from '../../api/recommendations.js';

import {
  PLAYER_PLAYLIST_ADD_ALBUM,
  PLAYER_PLAYLIST_ADD_TRACK_ACTION,
} from '../../store/action-types.js';

const WAITING_TIME_QUERY = 100; // [ms]

export default {
  data() {
    return {
      query: '',
      queryResults: false,
      waiting: false,
      recommendations: {
        albums: [],
      },
    };
  },
  computed: {
    ...mapState({
      currentServerIp: state => state.server.ip,
    }),
  },
  methods: {
    // Espera WAITING_TIME_QUERY para hacer la query, y comprueba que la query no ha cambiado para hacerla.
    async sendQuery() {
      if (this.query.length === 0) {
        this.queryResults = false;

        return;
      }

      const initialQuery = this.query;
      setTimeout(async () => {
        const actualQuery = this.query;
        if (actualQuery !== initialQuery) return;
        const results = (await MainApi.query({ 'arg': this.query })).data;
        const finalQuery = this.query;
        if (finalQuery !== initialQuery) return;
        this.queryResults = results;
      }, WAITING_TIME_QUERY);
    },
    async addTrack(id) {
      this.$store.dispatch({
        type: PLAYER_PLAYLIST_ADD_TRACK_ACTION,
        track: this.queryResults.tracks[id],
      });
    },
    async addAlbum(id) {
      const album = (await MainApi.getAlbum(id)).data.data;
      this.$store.dispatch({
        type: PLAYER_PLAYLIST_ADD_ALBUM,
        album,
      });
    },
  },
  async mounted() {
    this.recommendations.albums = (await RecommendationsApi.getAlbums()).data.random;
  },
};
</script>
<style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
</style>
