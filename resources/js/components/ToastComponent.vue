<template>
  <div></div>
</template>
<script>
export default {
  name: 'toast-component',
  props: {
    type: {
      type: String,
      required: true
    },
    message: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      options: {
        closeButton: true,
        progressBar: true,
        preventDuplicates: false,
        newestOnTop: true,
        positionClass: 'toast-top-right',
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
      }
    }
  },

  mounted () {
    window.toastr.options = this.options
    switch (this.type) {
      case 'success':
        window.toastr.success(this.message)
        break
      case 'message':
        window.toastr.info(this.message)
        break
      case 'error':
        window.toastr.options.progressBar = false
        window.toastr.options.timeOut = 0
        window.toastr.error(this.message)
        break
    }
  }
}
</script>
