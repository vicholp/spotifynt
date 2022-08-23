import api from './index';

export default {
  show(releaseId) {
    return api({
      method: 'get',
      url: `api/tracks/${releaseId}`,
    });
  },
};
