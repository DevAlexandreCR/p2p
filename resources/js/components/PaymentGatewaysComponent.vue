<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <button class="btn btn-outline-warning" @click="selectGateway('placeToPay')">
          <img :src="'/images/p2p.png'" alt="placeToPay" class="img-fluid rounded-circle">
        </button>
      </div>
      <div class="col-sm-6">
        <button class="btn btn-outline-danger" @click="selectGateway('fakePayment')">
          <img :src="'/images/fakepay.png'" alt="fakePayment" class="img-fluid rounded-circle">
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PaymentGatewaysComponent",
  props: {
    inputId: {
      type: String,
      required: true
    },
    formId: {
      type: String,
      required: true
    }
  },
  methods: {
    selectGateway: function(gateway) {
      document.getElementById(this.inputId).value = gateway
      document.getElementById(this.formId).submit()
    }
  }
}
</script>

<style scoped>

</style>