<template>
  <div :class="$style.login">
    <b-container>
      <b-row align-h="center">
        <b-col md="6" lg="4" class="text-center">
          <b-icon
            icon="controller"
            variant="light"
            font-scale="3.75"
            flip-v
            class="rounded bg-primary p-2 align-middle"
          />
          <h1 class="h2 mb-3">Sign in to sweepstakes</h1>
          <b-form class="login-form" @submit.prevent="performLogin">
            <b-form-group>
              <b-input-group>
                <b-form-input
                  v-model="login"
                  type="text"
                  placeholder="Username"
                  autocomplete="off"
                />
              </b-input-group>
              <b-input-group class="mb-2">
                <b-form-input
                  v-model="password"
                  type="password"
                  placeholder="Password"
                />
              </b-input-group>
            </b-form-group>
            <b-button block type="submit" variant="primary" :disabled="canSubmit">Sign in</b-button>
          </b-form>
          <p v-if="hasError" class="mt-2">
            <error-message :error="error" />
          </p>
        </b-col>
      </b-row>
    </b-container>
    <b-overlay :show="isLoading" spinner-variant="primary" blur="0" opacity="0.7" no-wrap fixed />
  </div>
</template>

<script>
import ErrorMessage from "../components/ErrorMessage";
export default {
  name: "Login",
  components: {
    ErrorMessage,
  },
  data() {
    return {
      login: "",
      password: ""
    };
  },
  computed: {
    canSubmit() {
      return this.login.length === 0 || this.password.length === 0 || this.isLoading;
    },
    isLoading() {
      return this.$store.getters["security/isLoading"];
    },
    hasError() {
      return this.$store.getters["security/hasError"];
    },
    error() {
      return this.$store.getters["security/error"];
    }
  },
  created() {
    let redirect = this.$route.query.redirect;

    if (this.$store.getters["security/isAuthenticated"]) {
      if (typeof redirect !== "undefined") {
        this.$router.push({path: redirect});
      } else {
        this.$router.push({path: "/home"});
      }
    }
  },
  methods: {
    async performLogin() {
      let payload = {login: this.$data.login, password: this.$data.password},
        redirect = this.$route.query.redirect;

      await this.$store.dispatch("security/login", payload);
      await this.$store.dispatch("app/load");
      if (!this.$store.getters["security/hasError"]) {
        if (typeof redirect !== "undefined") {
          await this.$router.push({path: redirect});
        } else {
          await this.$router.push({path: "/home"});
        }
      }
    }
  }
}
</script>

<style lang="scss" module>
  .login {
    display: flex;
    height: 100%;
    align-items: center;

    :global(.input-group) {
      &:first-child {
        input {
          margin-bottom: -1px !important;
          border-radius: 0.25rem 0.25rem 0 0;
        }
      }

      &:last-child {
        input {
          border-radius: 0 0 0.25rem 0.25rem;
        }
      }
    }
  }
</style>
