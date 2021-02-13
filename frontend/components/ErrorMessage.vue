<template>
  <div class="alert alert-danger" role="alert">
    {{ error }}
  </div>
</template>

<script>
export default {
  name: "ErrorMessage",
  props: {
    error: {
      type: String,
      required: true
    }
  },
}
</script>