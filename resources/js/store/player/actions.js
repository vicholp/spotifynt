import ReleaseApi from '../../api/release';
import ServerTrackApi from '../../api/serverTrack';

import ServerStore from '../server';

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
};
