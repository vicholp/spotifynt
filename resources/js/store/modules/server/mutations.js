import {
  SERVER_SET_CURRENT_SERVER,
} from '../../mutation-types';

export default {
  [SERVER_SET_CURRENT_SERVER](state, { server }) {
    state.ip = server;
  },
};
