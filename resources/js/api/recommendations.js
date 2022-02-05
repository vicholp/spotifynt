import api from './index';

export default {
  getAlbums() {
    return api({
      method: 'get',
      url: '/api/recommendations/albums',
    });
  },
};
