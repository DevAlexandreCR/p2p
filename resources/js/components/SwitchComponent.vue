<template>
  <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="enabled" checked>
  </div>
</template>

<script>
export default {
  name: 'SwitchComponent',

  props: {
    formId: {
      type: String,
      required: true
    },
    inputId: {
      type: String,
      required: true
    },

    status: {
      type: Boolean,
      required: true
    }
  },

  methods: {
    submit: function (event) {
      document.getElementById(this.inputId).value = event.target.value
      document.getElementById(this.formId).submit()
    }
  }
}
</script>

<style scoped>

</style>
