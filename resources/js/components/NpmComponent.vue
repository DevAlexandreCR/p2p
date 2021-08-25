<template>
  <div class="container mt-4">
    <div class="card w-50 m-auto">
      <div class="card-header">Creación de paquetes parte I</div>
      <div class="card-body">
        <h5 class="card-title">Calcula el área del circulo</h5>
        <div class="input-group my-3 input-group-sm row">
          <label for="exampleFormControlInput1" class="form-label me-4 col-sm-9">Ingresa el radio del círculo</label>
          <input type="number" class="form-control col-sm-2" placeholder="5" 
          v-model="ratio"
          id="exampleFormControlInput1" aria-describedby="basic-addon2">
          <span class="input-group-text col-sm-1" id="basic-addon2">cm</span>
        </div>
        <div class="mb-3 input-group input-group-sm row">
          <label for="staticEmail" class="col-sm-9 form-label me-4">El área del círculo es:</label>
          <input type="number" readonly class="form-control col-sm-2" aria-describedby="basic-addon1"
          id="staticEmail" v-model="area">
          <span class="input-group-text col-sm-1" id="basic-addon1">cm</span>
        </div>
      </div>
      <div class="card-footer text-end">
          <button class="btn btn-primary btn-sm" @click="calcular()">calcular</button>
      </div> 
    </div>
  </div>
</template>

<script>

import { area } from 'area-circulo-calc'

export default {
  name: "npm-component",
  created() {},
  data() {
    return {
      ratio: 0,
      area: 0
    };
  },
  props: {},
  methods: {
    calcular() {
      this.area = area(this.ratio);
    }
  },
};
</script>