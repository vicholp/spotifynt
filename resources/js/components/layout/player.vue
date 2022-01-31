<template>
  <div
    :class="`bottom-0 h-20 fixed border-t w-full flex shadow-lg ${color === false ? 'bg-white' : ''}`"
    :style="{
      'background-color': `${color}`,
      'border-color': `${color}`
    }"
  >
    <div class="container mx-auto my-auto px-3 p-3">
      <div
        class="flex gap-3 items-center"
      >
        <audio
          preload="auto"
          ref="player"
          @ended="trackEnded()"
          @loadedmetadata="loadMetadata"
          @timeupdate="checkPlayed"
        />
        <div
          v-if="actual"
          :style="{'background-image':`url(${getArtFromAlbum(this.actual.album.beetsId)})`}"
          class="h-14 bg-cover rounded shadow aspect-square"
        />
        <div
          v-else
          class="h-14 bg-cover rounded shadow aspect-square bg-gray-300"
        />
        <div
          v-if="actual"
          class="text-medium"
        >
          {{ actual.name }}
        </div>
        <div
          v-else
          class=""
        >
          The playlist is empty
        </div>
        <div
          v-if="actual"
          class="text-medium"
        >
          Artist
        </div>
        <div :class="`ml-auto flex items-center mr-10 ${actual ? 'opacity-100' : 'opacity-30'}`">
          <button
            class="text-4xl"
            @click="previousTrack()"
          >
            <span
              class="iconify"
              data-icon="ic:round-navigate-before"
            />
          </button>
          <button
            class="text-4xl"
            @click="playPause()"
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
            @click="nextTrack()"
          >
            <span
              class="iconify"
              data-icon="ic:round-navigate-next"
            />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import { mapState } from 'vuex';

import getArtFromAlbum from '../../helpers/getArtFromAlbum.js';

import StatsApi from '../../api/stats.js';

import {
  PLAYER_SET_INDEX,
} from '../../store/action-types.js';

export default {
  computed: {
    ...mapState({
      playlist: state => state.player.playlist,
      actual: state => state.player.actualTrack,
      status: state => state.player.status,
      color: state => state.player.color,
    }),
  },
  data() {
    return {
      totalTime: 0,
      listened: false,
      playing: false,
    };
  },
  methods: {
    getArtFromAlbum,
    playPause(action = null) {
      this.$set(this.status, 'playing', !this.status.playing);
      if (this.$refs.player.paused || action === 'play') {
        // sessionStorage.setItem("player_playing", 'playing');

        this.$refs.player.play();
      } else if (!this.$refs.player.paused || action === 'pause') {
        // sessionStorage.setItem("player_playing", 'paused');

        this.$refs.player.pause();
      }
    },
    trackEnded() {
      this.nextTrack();
    },
    nextTrack() {
      this.$store.dispatch({
        type: PLAYER_SET_INDEX,
        index: 1,
        relative: true,
      });
    },
    previousTrack() {
      this.$store.dispatch({
        type: PLAYER_SET_INDEX,
        index: -1,
        relative: true,
      });
    },
    loadMetadata(event) {
      this.totalTime = event.target.duration;
    },
    checkPlayed(event) {
      const progress = event.target.currentTime / this.totalTime;
      if ((progress > 0.5 || event.target.currentTime > 4 * 60) && this.listened === false) {
        this.listened = true;
        StatsApi.playedTrack(this.actual.id);
      }
      if (event.target.currentTime > 1 && this.playing === false) {
        this.playing = true;
        StatsApi.nowPlaying(this.actual.id);
      }
    },
    loadTrack(track) {
      navigator.mediaSession.metadata = new window.MediaMetadata({
        title: track.name,
        artist: track.artist.name,
        album: track.album.name,
        artwork: [
          { src: getArtFromAlbum(track.album.beetsId), sizes: '512x512', type: 'image/png' },
        ],
      });
      this.$refs.player.src = `http://192.168.1.5:9000/item/${track.beetsId}/file`;
      this.playPause('play');
      this.listened = false;
      this.playing = false;
    },
  },
  mounted() {
    if ('mediaSession' in navigator) {
      window.playerPreviousTrack = this.previousTrack;
      window.playerNextTrack = this.nextTrack;

      navigator.mediaSession.setActionHandler('previoustrack', () => window.playerPreviousTrack());
      navigator.mediaSession.setActionHandler('nexttrack', () => window.playerNextTrack());
    }
  },
  watch: {
    actual(track) {
      this.loadTrack(track);
    },
  },
};
</script>
