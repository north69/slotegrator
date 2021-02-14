import Vue from "vue";
import App from "./App";
import router from "./router";
import store from "./store";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Layouts
import DefaultDash from './layouts/Default.vue';
import None from './layouts/None.vue';

// Layouts as usable components
Vue.component('default-layout', DefaultDash);
Vue.component('none-layout', None);

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

store.dispatch("app/load").then(app_data => {
  store.dispatch("security/onRefresh", app_data);

  new Vue({
    render: h => h(App),
    router,
    store
  }).$mount('#app')
});

