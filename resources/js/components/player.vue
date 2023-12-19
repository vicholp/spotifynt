<template>
  <div
    class="w-full"
    @keyup.enter="playPause()"
  >
    <audio
      ref="player"
      preload="auto"
      @ended="nextTrack()"
      @loadedmetadata="loadMetadata"
      @timeupdate="checkPlayed"
      @canplaythrough="loadNextTrack"
      @waiting="loading = true"
      @playing="loading = false"
    />
    <audio
      ref="playerPreloader"
      preload="auto"
    />
    <transition name="slide-fade-down">
      <player-overlay
        v-if="playerOverlay"
        :auth-user="authUser"
        @player-play="playPause"
        @player-next="nextTrack"
        @player-prev="previousTrack"
        @toggle-overlay="playerOverlay = !playerOverlay"
      />
    </transition>
    <transition name="slide-fade-up">
      <player-bar
        v-if="!playerOverlay"
        :progress="progressPercent"
        :actual="playerStore.currentTrack"
        :playing="playerStore.status.playing"
        :loaded="playerStore.playlist.tracks.length > 0"
        :loading="loading"
        @player-play="playPause"
        @player-next="nextTrack"
        @player-prev="previousTrack"
        @toggle-overlay="playerOverlay = !playerOverlay"
      />
    </transition>
  </div>
</template>
<script>
import PlayerBar from './playerBar.vue';
import PlayerStore from '../store/player';
import ServerStore from '../store/server';

import StatsApi from '../api/stats';

const TIME_AFTER_LISTENED = 240; // [s]
const PROGRESS_AFTER_LISTENED = 0.5; // [%]

export default {
  components: {
    PlayerBar,
  },
  props: {
    authUser: {
      default: () => {},
      type: Object,
    },
  },
  setup() {
    const playerStore = PlayerStore();
    const serverStore = ServerStore();

    return { playerStore, serverStore };
  },
  data() {
    return {
      stats: {
        listened: false,
      },
      totalTime: 0,
      currentTime: 0,
      progressPercent: 0,
      listened: false,
      loading: false,
      playerOverlay: false,
    };
  },
  watch: {
    'playerStore.currentTrack'(track) {
      if (Object.keys(track).length !== 0){
        this.loadTrack(track);
      }else {
        document.title = 'spotifynt';
        this.clearTrack();
      }
    },
  },
  mounted() {
    if (Object.keys(this.playerStore.currentTrack).length === 0){
      document.title = 'spotifynt';
      return;
    }
    document.title = `${this.playerStore.currentTrack.title}`;
    this.$refs.player.src = `${this.serverStore.activeServer.path}/item/${this.playerStore.currentTrack.serverTrack.beetsId}/file`; // eslint-disable-line
  },
  methods: {
    clearTrack() {
      this.$refs.player.src = ``;
      this.$refs.playerPreloader.src = ``;
    },
    loadNextTrack() {
      const nextTrack = this.playerStore.getNextTrack;

      this.$refs.playerPreloader.src = `${this.serverStore.activeServer.path}/item/${nextTrack.serverTrack.beetsId}/file`; // eslint-disable-line
    },
    loadMetadata(event) {
      this.totalTime = event.target.duration;
    },
    loadTrack(track) {
      this.$refs.player.src = `${this.serverStore.activeServer.path}/item/${track.serverTrack.beetsId}/file`;
      this.$refs.playerPreloader.src = '';

      document.title = `${track.title}`;
      this.listened = false;
      this.playerStore.status.playing = false;
      this.playPause('play');
    },
    playPause(action = null) {
      if (this.$refs.player.paused || action === 'play') {
        this.playerStore.status.playing = true;
        this.$refs.player.play();
      } else if (!this.$refs.player.paused || action === 'pause') {
        this.playerStore.status.playing = false;
        this.$refs.player.pause();
      }
      this.loadMediaMetadata(this.playerStore.currentTrack);
    },
    nextTrack() {
      this.playerStore.playlistSetIndex(1, true);
    },
    previousTrack() {
      this.playerStore.playlistSetIndex(-1, true);
    },
    checkPlayed(event) {
      const progress = event.target.currentTime / this.totalTime;

      this.progressPercent = progress * 100;
      if (
        this.listened === false &&
        (progress > PROGRESS_AFTER_LISTENED || event.target.currentTime > TIME_AFTER_LISTENED)
      ) {
        this.listened = true;

        let data = {
          trackId: this.playerStore.currentTrack.id,
          userId: this.authUser.id,
          serverId: this.serverStore.activeServer.id,
          releaseId: this.playerStore.currentTrack.release.id,
        };
        StatsApi.playedTrack(data);
      }
      if (this.playerStore.status.playing === false && event.target.currentTime > 1) {
        // StatsApi.nowPlaying(this.actual.id);
      }
    },
    loadMediaMetadata(track) {
      if ('mediaSession' in navigator) {
        navigator.mediaSession.metadata = new MediaMetadata({
          title: track.title,
          artist: 'spotifynt',
          album: track.release.title,
          artwork: [
            { src: track.release.art[250], sizes: '250x250', type: 'image/webp' },
            { src: track.release.art[75], sizes: '75x75', type: 'image/webp' },
          ],
        });

        navigator.mediaSession.setActionHandler('play', () => this.playPause('play'));
        navigator.mediaSession.setActionHandler('pause', () => this.playPause('pause'));
        navigator.mediaSession.setActionHandler('previoustrack', () => this.previousTrack());
        navigator.mediaSession.setActionHandler('nexttrack', () => this.nextTrack());
      }
    },
  },
};
</script>

<style>
.slide-fade-down-enter-active {
  transition: all 0.1s ease-out;
}

.slide-fade-down-leave-active {
  transition: all 0.1s ease-in;
}

.slide-fade-down-enter-from,
.slide-fade-down-leave-to {
  transform: translateY(50%);
  opacity: 0;
}


.slide-fade-up-enter-active {
  transition: all 0.1s ease-out;
}

.slide-fade-up-leave-active {
  transition: all 0.1s ease-in;
}

.slide-fade-up-enter-from,
.slide-fade-up-leave-to {
  transform: translateY(-50%);
  opacity: 0;
}</style>

