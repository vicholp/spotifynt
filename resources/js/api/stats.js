import api from './index';

export default {
  playedTrack(serverId, trackId, userId) {
    return api({
      method: 'post',
      url: `api/stats/playedTrack`,
      data: {
        serverId,
        trackId,
        userId,
      },
    });
  },
};
