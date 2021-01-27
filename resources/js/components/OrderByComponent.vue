<template>
  <div class="row">
    <div class="col-6">
      <select class="form-select form-select-sm" aria-label="select order" name="orderBy" v-model="orderBy">
        <option selected :value="orderBySelected">{{ orderBySelected }}</option>
        <option v-for="by in fields" :value="by" :key="by">{{ by }}</option>
      </select>
    </div>
    <div class="col-6">
      <select class="form-select form-select-sm" aria-label="select order" name="order" @change="submit($event)">
        <option selected :value="orderSelected">{{ orderSelected }}</option>
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
      let form = document.getElementById(this.formId)
      let inputOrder = form.appendChild(document.createElement('input'))
      inputOrder.setAttribute('name', 'order')
      inputOrder.setAttribute('type', 'hidden')
      inputOrder.value = event.target.value
      let inputOrderBy = form.appendChild(document.createElement('input'))
      inputOrderBy.setAttribute('name', 'orderBy')
      inputOrderBy.setAttribute('type', 'hidden')
      inputOrderBy.value = this.orderBy
      form.submit()
    }
  }
}
</script>
