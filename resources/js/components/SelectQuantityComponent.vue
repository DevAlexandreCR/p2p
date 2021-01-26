<template>
  <div class="row">
    <div class="col-6"><label for="select-quantity">Quantity:</label></div>
    <div class="col-6">
      <select class="form-select form-select-sm" id="select-quantity"
              aria-label="Select quantity" @change="submit($event)">
        <option v-for="num in stockAvailable" :key="num" v-bind:selected="num === quantitySelected">{{ num }}</option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SelectQuantityComponent',

  props: {
    stockAvailable: {
      type: Number,
      default: 0,
      required: true
    },

    quantitySelected: {
      type: Number,
      default: 0,
      required: true
    },

    productId: {
      type: Number,
      default: 0,
      required: true
    },

    inputProduct: {
      type: String,
      default: 'inputId',
      required: true
    },

    inputQuantity: {
      type: String,
      default: 'inputId2',
      required: true
    },

    formId: {
      type: String,
      default: 'formId',
      required: true
    }
  },

  methods: {
    submit: function (event) {
      document.getElementById(this.inputProduct).value = this.productId
      document.getElementById(this.inputQuantity).value = event.target.value
      document.getElementById(this.formId).submit()
    }
  }
}
</script>
