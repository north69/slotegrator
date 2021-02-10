import Vue from "vue";
import Vuex from "vuex";
import ProductModule from "./product";
import SecurityModule from "./security"

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    security: SecurityModule,
    product: ProductModule
  }
});