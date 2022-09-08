<template>
  <div
    class="absolute w-full"
    @keyup.enter="playPause()"
  >
    <audio
      ref="player"
      preload="auto"
      @ended="nextTrack()"
      @loadedmetadata="loadMetadata"
      @timeupdate="checkPlayed"
      @canplaythrough="loadNextTrack"
    />
    <audio
      ref="playerPreloader"
      preload="auto"
    />
    <player-bar
      :progress="progressPercent"
      :actual="playerStore.currentTrack"
      :playing="playerStore.status.playing"
      :loaded="playerStore.playlist.tracks.length > 0"
      @player-play="playPause"
      @player-next="nextTrack"
      @player-prev="previousTrack"
    />
  </div>
</template>
<script>
import PlayerBar from './playerBar.vue';
import PlayerStore from '../store/player';
import ServerStore from '../store/server';

const TIME_AFTER_LISTENED = 240; // [s]
const PROGRESS_AFTER_LISTENED = 0.5; // [%]

export default {
  components: {
    PlayerBar,
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
    };
  },
  computed: {
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
    this.$refs.player.src = `${this.serverStore.activeServer.path}/item/${this.playerStore.currentTrack.serverTrack.beetsId}/file`;
  },
  methods: {
    clearTrack() {
      this.$refs.player.src = ``;
      this.$refs.playerPreloader.src = ``;
    },
    loadNextTrack() {
      const nextTrack = this.playerStore.getNextTrack;

      this.$refs.playerPreloader.src = `${this.serverStore.activeServer.path}/item/${nextTrack.serverTrack.beetsId}/file`;
    },
    loadMetadata(event) {
      this.totalTime = event.target.duration;
    },
    loadTrack(track) {
      this.$refs.player.src = `${this.serverStore.activeServer.path}/item/${track.serverTrack.beetsId}/file`;
      this.$refs.playerPreloader.src = '';

      document.title = `${track.name}`;
      this.listened = false;
      this.playerStore.status.playing = false;
      // setMediaMetadata(track);
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
    },
    nextTrack() {
      this.playerStore.playlistSetIndex(1, true);
    },
    previousTrack() {
      this.playerStore.playlistSetIndex(-1, true);
    },
    checkPlayed(event) {
      const progress = event.target.currentTime / this.totalTime;

      this.progress = progress * 100;
      if (
        this.listened === false &&
        (progress > PROGRESS_AFTER_LISTENED || event.target.currentTime > TIME_AFTER_LISTENED)
      ) {
        this.listened = true;
        // StatsApi.playedTrack(this.actual.id);
      }
      if (this.playerStore.status.playing === false && event.target.currentTime > 1) {
        // this.playerStore.status.playing = true;
        // StatsApi.nowPlaying(this.actual.id);
      }
    },
  },
};
</script>
