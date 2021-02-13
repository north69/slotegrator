<template>
  <div>
    <h2 class="mb-4 mt-4">Sweepstakes</h2>
    <b-row>
      <b-col md="8">
        <p v-if="!hasPrize && prizesAreAvailable">
          You should try win a prize
        </p>
        <p v-if="hasPrize">
          You have a prize
        </p>
        <p v-if="!prizesAreAvailable">
          There are no prizes left
        </p>
        <p v-if="hasError">
          <error-message :error="error" />
        </p>
      </b-col>
    </b-row>
    <b-overlay :show="isLoading" spinner-variant="primary" blur="0" opacity="0.7" no-wrap fixed />
  </div>
</template>

<script>
import ErrorMessage from "../components/ErrorMessage";

export default {
  name: "Home",
  components: {
    ErrorMessage
  },
  computed: {
    isLoading() {
      return this.$store.getters["prize/isLoading"];
    },
    hasError() {
      return this.$store.getters["prize/hasError"];
    },
    error() {
      return this.$store.getters["prize/error"];
    },
    hasPrize() {
      return this.$store.getters["prize/hasPrize"];
    },
    prizesAreAvailable() {
      return this.$store.getters["app/prizesAreAvailable"];
    },
    prize() {
      return this.$store.getters["prize/prize"];
    }
  },
  created() {
    this.$store.dispatch("prize/getItem");
  }
};
</script>
