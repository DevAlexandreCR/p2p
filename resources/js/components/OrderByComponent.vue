<template>
  <div class="row ms-2">
    <div class="col-6">
      <select class="form-select form-select-sm" aria-label="select order" name="orderBy" @change="submit()">
        <option selected :value="'created_at'">Order By</option>
        <option v-for="by in orderBy" :value="by" :key="by">{{ by }}</option>
      </select>
    </div>
    <div class="col-6">
      <select class="form-select form-select-sm" aria-label="select order" name="order" @change="submit()">
        <option selected :value="'asc'">Asc</option>
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
      orderBy: [
        'price',
        'name'
      ]
    }
  },

  props: {
    formId: {
      type: String,
      required: true
    }
  },

  methods: {
    submit: function () {
      document.getElementById(this.formId).submit()
    }
  }
}
</script>
