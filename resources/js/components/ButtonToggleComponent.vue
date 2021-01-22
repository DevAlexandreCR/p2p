<template>
  <div class="container-fluid">
    <button class="btn btn-light shadow-sm" v-on:click="toggle" id="menu-toggle">
     <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</template>

<script>
export default {
  name: 'ButtonToggleComponent',
  methods: {
    toggle (e) {
      e.preventDefault()
      document.getElementById('wrapper').classList.toggle('toggled')
    }
  }
}
</script>

<style scoped>

</style>
