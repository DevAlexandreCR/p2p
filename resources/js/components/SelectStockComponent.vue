<template>
  <div>
    <select class="form-select form-select-sm pe-5" :name="selectName"  aria-label="Select quantity" @change="total($event)">
      <option v-for="num in stockAvailable">{{ num }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: "SelectStockComponent",

  props: {
    stockAvailable: {
      type: Number,
      default: 0,
      required: true
    },

    price: {
      type: Number,
      default: 0,
      required: true
    },

    inputPrintId: {
      type: String,
      default: 'inputId',
      required: true
    },

    selectName: {
      type: String,
      default: 'selectName',
      required: true
    }
  },

  methods: {
    total: function(event) {
      let quantity = event.target.value
      document.getElementById(this.inputPrintId).textContent = this.numberFormatter(this.price * quantity)
    },

    numberFormatter:function (number){
      const val = new Intl.NumberFormat('en').format(number)
      return `$ ${val}`
    }
  }
}
</script>