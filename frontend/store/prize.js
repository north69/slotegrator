import PrizeAPI from "../api/prize";

const CREATING = "CREATING",
  CREATING_SUCCESS = "CREATING_SUCCESS",
  CREATING_ERROR = "CREATING_ERROR",
  FETCHING_PRIZE = "FETCHING_PRIZE",
  FETCHING_PRIZE_SUCCESS = "FETCHING_PRIZE_SUCCESS",
  FETCHING_PRIZE_ERROR = "FETCHING_PRIZE_ERROR";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    prize: null
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
    hasPrize(state) {
      return state.prize !== null;
    },
    prize(state) {
      return state.prize;
    }
  },
  mutations: {
    [CREATING](state) {
      state.isLoading = true;
      state.error = null;
    },
    [CREATING_SUCCESS](state) {
      state.isLoading = false;
      state.error = null;
    },
    [CREATING_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
    },
    [FETCHING_PRIZE](state) {
      state.isLoading = true;
      state.error = null;
      state.prize = null;
    },
    [FETCHING_PRIZE_SUCCESS](state, prize) {
      state.isLoading = false;
      state.error = null;
      state.prize = prize;
    },
    [FETCHING_PRIZE_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.prize = null;
    }
  },
  actions: {
    async create({ commit }) {
      commit(CREATING);
      try {
        let create_response = await PrizeAPI.create();
        if (create_response.status !== 204) {
          commit(CREATING_ERROR, 'There is an error occurred during generating a prize');
          return null;
        }
        let get_response = await PrizeAPI.get();
        if (get_response.status !== 200) {
          commit(CREATING_ERROR, 'There is an error occurred during generating a prize');
          return null;
        }
        let prize = get_response.data.length > 0 ? get_response.data[0] : null;
        if (!prize) {
          commit(CREATING_ERROR, 'There is an error occurred during generating a prize');
          return null;
        }
        commit(CREATING_SUCCESS);
        return prize;
      } catch (error) {
        commit(CREATING_ERROR, 'There is an error occurred during generating a prize');
        return null;
      }
    },
    async getItem({ commit }) {
      commit(FETCHING_PRIZE);
      try {
        let response = await PrizeAPI.get();
        if (response.status !== 200) {
          commit(FETCHING_PRIZE_ERROR, 'There is an error occurred during fetching a prize');
          return null;
        }
        let prize = response.data.length > 0 ? response.data[0] : null;
        commit(FETCHING_PRIZE_SUCCESS, prize);
        return response.data;
      } catch (error) {
        commit(FETCHING_PRIZE_ERROR, 'There is an error occurred during fetching a prize');
        return null;
      }
    }
  }
};