import api from './index';

export default {
  show(serverId, trackId) {
    return api({
      method: 'get',
      url: `api/servers/${serverId}/tracks/${trackId}`,
    });
  },
};
