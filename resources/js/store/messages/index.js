import { defineStore } from 'pinia';

import actions from './actions';
import state from './state';
import getters from './getters';

export default defineStore('messages', {
  actions,
  state,
  persist: true,
  getters,
});
