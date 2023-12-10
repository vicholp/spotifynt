import ReleaseApi from '../../api/release';
import ServerTrackApi from '../../api/serverTrack';

import ServerStore from '../server';
import MessagesStore from '../messages';

export default {
  playlistAddTrack(track) {
    this.playlist.tracks.push(track);
    this.playlist.count++;

    if (this.playlist.count === 1) {
      this.loadTrack();
    }
  },

  async playlistAddTrackById(trackId) {
    const serverStore = ServerStore();
    const serverId = serverStore.activeServer.id;
    const track = (await ServerTrackApi.show(serverId, trackId)).data.data;
    this.playlistAddTrack(track);
  },

  async playlistAddAlbum(albumId) {
    const album = (await ReleaseApi.show(albumId)).data.data;

    album.tracks.forEach(track => {
      this.playlistAddTrackById(track.id);
    });

    const messagesStore = MessagesStore();
    messagesStore.addedTracks(album.tracks.length);
  },

  async playlistSetIndex(int, relative) {
    if (relative) {
      this.playlist.index += int;
    } else {
      this.playlist.index = int;
    }
    if (this.playlist.index >= 0) {
      this.playlist.index %= this.playlist.count;
    } else {
      this.playlist.index = this.playlist.count + this.playlist.index;
    }
    this.loadTrack();
  },

  async loadTrack() {
    this.currentTrack = this.playlist.tracks[this.playlist.index];
  },

  playlistShuffle() {
    const tracks = this.playlist.tracks;
    let temp = {};
    let j = 0;

    for (let i = tracks.length - 1; i > 0; i--) {
      j = Math.floor(Math.random() * (i + 1));
      temp = tracks[i];
      tracks[i] = tracks[j];
      tracks[j] = temp;
    }

    this.playlist.tracks = tracks;
  },
  async playlistClear() {
    this.playlist.tracks = [];
    this.playlist.count = 0;
    this.playlist.index = 0;
    this.currentTrack = {};

    this.status.playing = false;
    this.status.time = 0;
  },
};
