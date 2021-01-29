<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <button class="btn" @click="selectGateway" value="placeToPay">placetopay</button>
      </div>
      <div class="col-sm-6">
        <button class="btn" @click="selectGateway" value="fakePayment">fakerpayment</button>
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
    selectGateway: function(event) {
      document.getElementById(this.inputId).value = event.target.value
      document.getElementById(this.formId).submit()
    }
  }
}
</script>

<style scoped>

</style>