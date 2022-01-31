import FastAverageColor from 'fast-average-color';

import {
  PLAYER_PLAYLIST_ADD_ALBUM,
  PLAYER_NEXT,
  PLAYER_PREVIOUS,
  PLAYER_SET_INDEX,
  PLAYER_LOAD_TRACK,
  PLAYER_PLAYLIST_ADD_TRACK_ACTION,
} from '../../action-types';

import {
  PLAYER_PLAYLIST_ADD_TRACK,
  PLAYER_PLAYLIST_SET_INDEX,
  PLAYER_SET_BACKGROUND_COLOR,
  PLAYER_SET_ACTUAL_TRACK,
} from '../../mutation-types';

export default {
  async [PLAYER_PLAYLIST_ADD_TRACK_ACTION]({ commit, state, dispatch }, { track }) {
    commit({
      type: PLAYER_PLAYLIST_ADD_TRACK,
      track,
    });
    if (state.playlist.count === 1) {
      dispatch({
        type: PLAYER_LOAD_TRACK,
      });
    }
  },
  async [PLAYER_LOAD_TRACK]({ commit, state }) {
    const track = state.playlist.tracks[state.playlist.index];

    const fac = new FastAverageColor();

    const color = await fac.getColorAsync(`http://192.168.1.5:9000/album/${track.album.beetsId}/art`);

    commit({
      type: PLAYER_SET_BACKGROUND_COLOR,
      color: color.hex,
    });

    commit({
      type: PLAYER_SET_ACTUAL_TRACK,
      track,
    });
  },
  [PLAYER_PLAYLIST_ADD_ALBUM]({ commit, dispatch }, { album }) {
    album.tracks.forEach(track => {
      dispatch({
        type: PLAYER_PLAYLIST_ADD_TRACK_ACTION,
        track,
      });
    });

    dispatch({
      type: PLAYER_LOAD_TRACK,
    });
  },
  async [PLAYER_SET_INDEX]({ commit, dispatch }, { index, relative }) {
    commit({
      type: PLAYER_PLAYLIST_SET_INDEX,
      index,
      relative,
    });

    dispatch({
      type: PLAYER_LOAD_TRACK,
    });
  },
  [PLAYER_NEXT]({ commit }) {
    commit({
      type: PLAYER_PLAYLIST_SET_INDEX,
      index: 1,
      relative: true,
    });
  },
  [PLAYER_PREVIOUS]({ commit }) {
    commit({
      type: PLAYER_PLAYLIST_SET_INDEX,
      index: -1,
      relative: true,
    });
  },
};
