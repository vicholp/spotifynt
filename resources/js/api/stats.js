import api from './index';

export default {
  playedTrack(data) {
    return api({
      method: 'post',
      url: `api/stats/playedTrack`,
      data,
    });
  },
};
