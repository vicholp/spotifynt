<template>
  <div
    :class="`absolute w-full ${full ? 'top-0 h-full' : 'bottom-0 h-20'}`"
  >
    <audio
      preload="auto"
      ref="player"
      @ended="nextTrack()"
      @loadedmetadata="loadMetadata"
      @timeupdate="checkPlayed"
    />
    <player-full
      v-if="full"
      @go-mini="full = false"
      :progress="progress"
      :actual="actual"
      :loaded="playlist.loaded"
      @previus-track="previousTrack()"
      @next-track="nextTrack()"
      @play-pause="playPause()"
    />
    <player-mini
      v-else
      @go-full="full = true"
      :progress="progress"
      :actual="actual"
      :loaded="playlist.loaded"
      @previus-track="previousTrack()"
      @next-track="nextTrack()"
      @play-pause="playPause()"
    />
  </div>
</template>
<script>
import { mapState } from 'vuex';

import getArtFromAlbum from '../../../helpers/getArtFromAlbum.js';
import setMediaMetadata from '../../../helpers/setMediaMetadata.js';

import PlayerFull from './full.vue';
import PlayerMini from './mini.vue';

import StatsApi from '../../../api/stats.js';

import {
  PLAYER_SET_INDEX,
} from '../../../store/action-types.js';

const TIME_AFTER_LISTENED = 240; // [s]
const PROGRESS_AFTER_LISTENED = 0.5; // [%]

export default {
  components: {
    PlayerFull,
    PlayerMini,
  },
  computed: {
    ...mapState({
      playlist: state => state.player.playlist,
      actual: state => state.player.actualTrack,
      status: state => state.player.status,
      color: state => state.player.color,
      currentServerIp: state => state.server.ip,
    }),
  },
  data() {
    return {
      totalTime: 0,
      currentTime: 0,
      progress: 0,
      listened: false,
      playing: false,
      full: false,
    };
  },
  methods: {
    getArtFromAlbum,
    playPause(action = null) {
      if (this.$refs.player.paused || action === 'play') {
        this.$set(this.status, 'playing', true);
        this.$refs.player.play();
      } else if (!this.$refs.player.paused || action === 'pause') {
        this.$set(this.status, 'playing', false);
        this.$refs.player.pause();
      }
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
      this.progress = progress * 100;
      if (
        this.listened === false &&
        (progress > PROGRESS_AFTER_LISTENED || event.target.currentTime > TIME_AFTER_LISTENED)
      ) {
        this.listened = true;
        StatsApi.playedTrack(this.actual.id);
      }
      if (this.playing === false && event.target.currentTime > 1) {
        this.playing = true;
        StatsApi.nowPlaying(this.actual.id);
      }
    },
    loadTrack(track) {
      this.$refs.player.src = `${this.currentServerIp}/item/${track.beetsId}/file`;
      this.listened = false;
      this.playing = false;

      setMediaMetadata(track);
      this.playPause('play');
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
