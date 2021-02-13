import Vue from "vue";
import Vuex from "vuex";
import AppModule from "./app";
import PrizeModule from "./prize";
import SecurityModule from "./security"

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app: AppModule,
    security: SecurityModule,
    prize: PrizeModule
  }
});