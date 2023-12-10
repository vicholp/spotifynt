export default {
  addedTracks(n) {
    this.tracksCount += n;
    this.setMessage(`Added ${this.tracksCount} tracks to the playlist.`);
    this.show = true;
  },
  setMessage(message) {
    this.message = message;

    if (message == "") return;

    clearTimeout(this.timer);
    this.timer = setTimeout(() => {
      this.clearMessage();
    }, 3000);
  },
  clearMessage() {
    this.show = false;
    this.tracksCount = 0;

    setTimeout(() => {
      this.setMessage("");
    }, 1000);
  },
};
