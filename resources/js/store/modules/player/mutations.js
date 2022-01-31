import {
  PLAYER_PLAYLIST_ADD_TRACK,
  PLAYER_PLAYLIST_SET_INDEX,
  PLAYER_SET_BACKGROUND_COLOR,
  PLAYER_SET_ACTUAL_TRACK,
} from '../../mutation-types';

export default {
  [PLAYER_PLAYLIST_ADD_TRACK](state, { track }) {
    state.playlist.tracks.push(track);
    state.playlist.count += 1;
    state.playlist.loaded = true;
  },
  [PLAYER_PLAYLIST_SET_INDEX](state, { index, relative = false }) {
    if (relative) {
      state.playlist.index += index;
    } else {
      state.playlist.index = index;
    }
    if (state.playlist.index >= 0) {
      state.playlist.index %= state.playlist.count;
    } else {
      state.playlist.index = state.playlist.count + state.playlist.index;
    }
  },
  [PLAYER_SET_BACKGROUND_COLOR](state, { color }) {
    state.color = color;
  },
  [PLAYER_SET_ACTUAL_TRACK](state, { track }) {
    state.actualTrack = track;
  },

};
