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
    this.$store.dispatch("app/load");
    console.log(1);

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

