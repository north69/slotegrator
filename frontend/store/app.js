import AppAPI from "../api/app";

const FETCHING = "FETCHING",
  FETCHING_SUCCESS = "FETCHING_SUCCESS",
  FETCHING_ERROR = "FETCHING_ERROR";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    prizesAreAvailable: false,
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
    prizesAreAvailable(state) {
      return state.prizesAreAvailable;
    }
  },
  mutations: {
    [FETCHING](state) {
      state.isLoading = true;
      state.error = null;
      state.prizesAreAvailable = false;
      state.user = null;
    },
    [FETCHING_SUCCESS](state, payload) {
      state.isLoading = false;
      state.error = null;
      state.prizesAreAvailable = payload.prizesAreAvailable;
      state.user = payload.user
    },
    [FETCHING_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.prizesAreAvailable = false;
      state.user = null;
    }
  },
  actions: {
    async load({commit}) {
      commit(FETCHING);
      try {
        let response = await AppAPI.get();
        if (response.status !== 200) {
          commit(FETCHING_ERROR, response.data.errors[0].message);
          return false;
        }
        commit(FETCHING_SUCCESS, response.data);
        await this.$store.dispatch("security/onRefresh", response.data);
        return response.data;
      } catch (error) {
        commit(FETCHING_ERROR, 'There is an error occurred during request');
        return null;
      }
    }
  }
}