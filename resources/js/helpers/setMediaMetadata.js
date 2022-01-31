import getArtFromAlbum from './getArtFromAlbum.js';

export default function (track) {
  if ('mediaSession' in navigator) {
    navigator.mediaSession.metadata = new window.MediaMetadata({
      title: track.name,
      artist: track.artist.name,
      album: track.album.name,
      artwork: [
        { src: getArtFromAlbum(track.album.beetsId), sizes: '512x512', type: 'image/png' },
      ],
    });
  }
}
