import api from './index';

export default {
  playedTrack(trackId) {
    return api({
      method: 'post',
      url: '/api/stats/played-track',
      data: {
        trackId,
      },
    });
  },
  nowPlaying(trackId) {
    return api({
      method: 'post',
      url: '/api/stats/now-playing',
      data: {
        trackId,
      },
    });
  },
};
