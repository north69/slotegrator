<template>
  <div>
    <h2 class="mb-4 mt-4">Page with prizes</h2>
    <b-row>
      <b-col md="8">
        <p v-if="hasError">
          <error-message :error="error" />
        </p>
        <div v-else-if="!hasPrize && prizesAreAvailable">
          <b-overlay :show="isLoading" rounded="sm">
            <b-jumbotron header="Great news!" lead="There is a chance to win money, gift or some schmeckles">
              <p>You should try to win a prize</p>
              <b-button variant="primary" href="#">Let's try</b-button>
            </b-jumbotron>
          </b-overlay>
        </div>
        <div v-else-if="hasPrize">
            <b-card title="Congratulations!" :aria-hidden="isLoading ? 'true' : null">
              <b-card-text>You have a prize</b-card-text>
            </b-card>
        </div>
        <p v-else-if="!prizesAreAvailable">
          There are no prizes left
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
