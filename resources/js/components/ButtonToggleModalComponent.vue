<template>
  <div>
    <button class="btn btn-light btn-sm" data-bs-toggle="modal"
            data-bs-target="#product-modal" @click="show">
      <i class="bi bi-eye-fill"></i>
    </button>
  </div>
</template>

<script>
export default {
  name: 'ButtonToggleModalComponent',
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  methods: {
    show: function () {
      this.$root.$emit('product', this.product)
    }
  }
}
</script>
