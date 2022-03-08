import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist';
import player from './modules/player';
import server from './modules/server';

Vue.use(Vuex);

const vuexLocal = new VuexPersistence({
  storage: window.localStorage,
  key: 'vuex-spotifynt',
});

export default new Vuex.Store({
  modules: {
    player,
    server,
  },
  plugins: [vuexLocal.plugin],
});
