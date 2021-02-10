<template>
  <component :is="layout" id="app">
    <router-view />
  </component>
</template>

<script>
import axios from "axios";

export default {
  name: 'App',
  computed: {
    layout() {
      return `${this.$route.meta.layout || 'default'}-layout`;
    }
  },
  created() {
    let isAuthenticated = JSON.parse(this.$parent.$el.attributes["data-is-authenticated"].value),
        user = JSON.parse(this.$parent.$el.attributes["data-user"].value);

    let payload = { isAuthenticated: isAuthenticated, user: user };
    this.$store.dispatch("security/onRefresh", payload);

    axios.interceptors.response.use(undefined, (err) => {
      return new Promise(() => {
        if (err.response.status === 401) {
          this.$router.push({path: "/login"})
        } else if (err.response.status === 500) {
          document.open();
          document.write(err.response.data);
          document.close();
        }
        throw err;
      });
    });
  },
}
</script>

<style>
html, body, #app {
  height: 100%;
}
</style>

