import api from './index';

export default {
  random(serverId) {
    return api({
      method: 'get',
      url: `api/servers/${serverId}/recommendations/random`,
    });
  },
};
