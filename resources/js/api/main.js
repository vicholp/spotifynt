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
  getTrack(id) {
    return api({
      method: 'get',
      url: `/api/tracks/${id}`,
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
