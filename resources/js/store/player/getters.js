
export default {
  getNextTrack() {
    let index = this.playlist.index;
    index++;

    if (index >= 0) {
      index %= this.playlist.count;
    } else {
      index = this.playlist.count + index;
    }

    return this.playlist.tracks[index];
  },
};
