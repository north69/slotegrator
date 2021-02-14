import SecurityAPI from "../api/security";
import store from "../store"

const AUTHENTICATING = "AUTHENTICATING",
  AUTHENTICATING_SUCCESS = "AUTHENTICATING_SUCCESS",
  AUTHENTICATING_ERROR = "AUTHENTICATING_ERROR",
  PROVIDING_DATA_ON_REFRESH_SUCCESS = "PROVIDING_DATA_ON_REFRESH_SUCCESS",
  STARTING_LOGOUT = "STARTING_LOGOUT",
  LOGOUT = "LOGOUT";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    isAuthenticated: false,
    user: null
  },
  getters: {
    isLoading(state) {
      return state.isLoading;
    },
    hasError(state) {
      return state.error !== null;
    },
    error(state) {
      return state.error;
    },
    isAuthenticated(state) {
      return state.isAuthenticated;
    },
    getUsername(state) {
      return state.user.username;
    },
    getUserId(state) {
      return state.user.id;
    }
  },
  mutations: {
    [AUTHENTICATING](state) {
      state.isLoading = true;
      state.error = null;
      state.isAuthenticated = false;
      state.user = null;
    },
    [AUTHENTICATING_SUCCESS](state, payload) {
      state.isLoading = false;
      state.error = null;
      state.isAuthenticated = true;
      state.user = payload.user;
    },
    [AUTHENTICATING_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.isAuthenticated = false;
      state.user = null;
    },
    [PROVIDING_DATA_ON_REFRESH_SUCCESS](state, payload) {
      state.isLoading = false;
      state.error = null;
      state.isAuthenticated = !!payload.user;
      state.user = payload.user;
    },
    [STARTING_LOGOUT](state) {
      state.isLoading = true;
    },
    [LOGOUT](state) {
      state.isLoading = false;
      state.isAuthenticated = false;
      state.user = null;
    }
  },
  actions: {
    async login({commit}, payload) {
      commit(AUTHENTICATING);
      try {
        let response = await SecurityAPI.login(payload.login, payload.password);
        if (response.status !== 204) {
          commit(AUTHENTICATING_ERROR, response.data.errors[0].message);
          return false;
        }
        let app_data = await store.dispatch("app/load");
        commit(AUTHENTICATING_SUCCESS, app_data);
        return true;
      } catch (error) {
        commit(AUTHENTICATING_ERROR, 'There is an error occurred during request');
        return null;
      }
    },
    async logout({commit}) {
      commit(STARTING_LOGOUT);
      await SecurityAPI.logout();
      commit(LOGOUT);
    },
    onRefresh({commit}, payload) {
      commit(PROVIDING_DATA_ON_REFRESH_SUCCESS, payload);
    }
  }
}