<template>
  <div :class="$style.layout">
    <header :class="$style.header">
      <b-navbar type="light" class="border-bottom">
        <b-navbar-brand to="/home">
          <b-icon icon="controller" variant="light" font-scale="1.45" class="rounded-circle bg-primary p-1 align-middle" />
          Sweepstakes
        </b-navbar-brand>
        <b-collapse is-nav>
          <b-navbar-nav v-if="isAuthenticated" class="align-items-center ml-auto">
            <b-nav-item-dropdown right>
              <template v-slot:button-content>
                <em>{{ getUsername }}</em>
              </template>
              <b-dropdown-item @click="logout()">Sign out</b-dropdown-item>
            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
    </header>
    <main role="main" :class="$style.main">
      <b-container fluid>
        <slot />
      </b-container>
    </main>
    <footer :class="[$style.footer, 'border-top']">
      <b-container fluid>
        <small>
          Sweepstakes
          © 2021
        </small>
      </b-container>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'Default',
  computed: {
    isAuthenticated() {
      return this.$store.getters['security/isAuthenticated']
    },
    getUsername() {
      return this.$store.getters['security/getUsername']
    }
  },
  methods: {
    async logout() {
      await this.$store.dispatch("security/logout");
      await this.$router.push({path: "/login"});
    }
  }
}
</script>

<style lang="scss" module>
  :global(.navbar) {
    padding-left: 2rem;
    padding-right: 2rem;
    z-index: 1000;
  }

  :global(.container),
  :global(.container-fluid) {
    padding-left: 2rem;
    padding-right: 2rem;
  }

  .layout {
    display: flex;
    flex-direction: column;
  }

  .header {}

  .main {
    flex: 1;
    padding-bottom: 2rem;
  }

  .footer {
    padding: 1rem 0;
  }
</style>
