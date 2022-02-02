import FastAverageColor from 'fast-average-color';

import {
  PLAYER_PLAYLIST_ADD_ALBUM,
  PLAYER_SET_INDEX,
  PLAYER_LOAD_TRACK,
  PLAYER_PLAYLIST_ADD_TRACK_ACTION,
  PLAYER_PLAYLIST_SHUFFLE,
} from '../../action-types';

import {
  PLAYER_PLAYLIST_ADD_TRACK,
  PLAYER_PLAYLIST_SET_INDEX,
  PLAYER_SET_BACKGROUND_COLOR,
  PLAYER_SET_ACTUAL_TRACK,
  PLAYER_PLAYLIST_SET_TRACKS,
} from '../../mutation-types';

export default {
  [PLAYER_PLAYLIST_ADD_ALBUM]({ dispatch }, { album }) {
    album.tracks.forEach(track => {
      dispatch({
        type: PLAYER_PLAYLIST_ADD_TRACK_ACTION,
        track,
      });
    });
  },
  [PLAYER_PLAYLIST_ADD_TRACK_ACTION]({ commit, state, dispatch }, { track }) {
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
  [PLAYER_PLAYLIST_SHUFFLE]({ commit, state }) {
    const tracks = state.playlist.tracks;

    for (let i = tracks.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      const temp = tracks[i];
      tracks[i] = tracks[j];
      tracks[j] = temp;
    }

    commit({
      type: PLAYER_PLAYLIST_SET_TRACKS,
      tracks,
      count: state.playlist.count,
    });
  },
  async [PLAYER_LOAD_TRACK]({ commit, state }) {
    const track = state.playlist.tracks[state.playlist.index];

    commit({
      type: PLAYER_SET_ACTUAL_TRACK,
      track,
    });

    const color = await (new FastAverageColor())
      .getColorAsync(`http://192.168.1.5:9000/album/${track.album.beetsId}/art`);

    commit({
      type: PLAYER_SET_BACKGROUND_COLOR,
      color: color.hex,
    });
  },
  [PLAYER_SET_INDEX]({ commit, dispatch }, { index, relative }) {
    commit({
      type: PLAYER_PLAYLIST_SET_INDEX,
      index,
      relative,
    });

    dispatch({
      type: PLAYER_LOAD_TRACK,
    });
  },
};
