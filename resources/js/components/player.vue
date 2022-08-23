<template>
  <div
    :class="`absolute w-full ${full ? 'top-0 h-full' : 'bottom-0 h-20'}`"
  >
    <audio
      ref="player"
      preload="auto"
      @ended="nextTrack()"
      @loadedmetadata="loadMetadata"
      @timeupdate="checkPlayed"
    />
    <player-bar
      :progress="progress"
      :actual="playerStore.currentTrack"
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
      playing: false,
    };
  },
  computed: {
  },
  watch: {
    'playerStore.currentTrack'(track) {
      this.loadTrack(track);
    },
  },
  mounted() {

  },
  methods: {
    loadMetadata(event) {
      this.totalTime = event.target.duration;
    },
    loadTrack(track) {
      this.$refs.player.src = `${this.serverStore.activeServer.path}/item/${this.playerStore.currentTrack.serverTrack.beetsId}/file`;
      document.title = `${track.name}`;
      this.listened = false;
      this.playing = false;
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
      if (this.playing === false && event.target.currentTime > 1) {
        this.playing = true;
        // StatsApi.nowPlaying(this.actual.id);
      }
    },
  },
};
</script>
