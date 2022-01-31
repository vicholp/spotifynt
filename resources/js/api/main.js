import api from './index';

export default {
  getAlbums() {
    return api({
      method: 'get',
      url: '/api/albums',
    });
  },
  getAlbum(id) {
    return api({
      method: 'get',
      url: `/api/albums/${id}`,
    });
  },
  query(params) {
    return api({
      method: 'get',
      url: '/api/query',
      params,
    });
  },
};
