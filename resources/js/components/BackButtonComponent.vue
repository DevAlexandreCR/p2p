<template>
  <div class="me-lg-5 me-2">
    <button type="button" class="btn btn-light text-muted fw-bold back-button shadow-sm" @click="goBack">
      <i class="bi bi-arrow-left me-2"></i>
      Go back
    </button>
  </div>
</template>

<script>
export default {
  name: "BackButtonComponent",
  methods: {
    goBack() {
      history.back()
    }
  }
}
</script>