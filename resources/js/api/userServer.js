import api from './index';

export default {
  index(userId) {
    return api({
      method: 'get',
      url: `api/users/${userId}/servers`,
    });
  },
  store(serverId, userId) {
    return api({
      method: 'post',
      url: `api/users/${userId}/servers`,
      data: {
        serverId,
      },
    });
  },
};
