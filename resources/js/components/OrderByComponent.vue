<template>
  <div class="row">
    <div class="col-6">
      <select class="form-select form-select-sm" aria-label="select order" name="orderBy" v-model="orderBy">
        <option selected :value="orderBySelected">{{ capitalize(orderBySelected) }}</option>
        <option v-for="by in fields" :value="by" :key="by">{{ capitalize(by) }}</option>
      </select>
    </div>
    <div class="col-6">
      <select class="form-select form-select-sm" aria-label="select order" name="order" @change="submit($event)">
        <option selected :value="orderSelected">{{ capitalize(orderSelected) }}</option>
        <option :value="'asc'">Asc</option>
        <option :value="'desc'">Desc</option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  name: 'OrderByComponent',

  data () {
    return {
      fields: [
        'price',
        'name'
      ],
      orderBy: this.orderBySelected
    }
  },

  props: {
    formId: {
      type: String,
      required: true
    },
    orderBySelected: {
      type: String,
      required: false,
      default: 'Order By'
    },
    orderSelected: {
      type: String,
      required: false,
      default: 'Order'
    }

  },

  methods: {
    submit: function (event) {
      const form = document.getElementById(this.formId)
      const inputOrder = form.appendChild(document.createElement('input'))
      inputOrder.setAttribute('name', 'order')
      inputOrder.setAttribute('type', 'hidden')
      inputOrder.value = event.target.value
      const inputOrderBy = form.appendChild(document.createElement('input'))
      inputOrderBy.setAttribute('name', 'orderBy')
      inputOrderBy.setAttribute('type', 'hidden')
      inputOrderBy.value = this.orderBy
      form.submit()
    },

    capitalize: function (str) {
      const lower = str.toLowerCase()
      return str.charAt(0).toUpperCase() + lower.slice(1)
    }
  }
}
</script>
