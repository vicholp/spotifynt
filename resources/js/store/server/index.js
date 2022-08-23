import { defineStore } from 'pinia';

import actions from './actions';
import state from './state';

export default defineStore('server', {
  actions,
  state,
});
