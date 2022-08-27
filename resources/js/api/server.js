import api from './index';

export default {
  index() {
    return api({
      method: 'get',
      url: 'api/server',
    });
  },
  searchContent(serverId, query) {
    return api({
      method: 'get',
      url: `api/server/${serverId}/searchContent?q=${query}`,
    });
  },
  show(serverId) {
    return api({
      method: 'get',
      url: `api/server/${serverId}`,
    });
  },
};
