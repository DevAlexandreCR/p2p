<template>
  <div class="form-check form-switch mx-2">
    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="enabled"
           :checked="changeStatus" @click="submit()">
  </div>
</template>

<script>
export default {
  name: 'SwitchComponent',

  data() {
    return {
      changeStatus: false
    }
  },

  props: {
    formId: {
      type: String,
      required: true
    },
    action: {
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
    submit: function () {
      this.changeStatus = !this.changeStatus  ? 1 : 0
      document.getElementById(this.inputId).value = this.changeStatus
      document.getElementById(this.formId).action = this.action
      document.getElementById(this.formId).submit()
    }
  },

  mounted() {
    this.changeStatus = this.status
  }
}
</script>
