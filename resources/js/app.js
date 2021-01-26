import Vue from 'vue'
import './bootstrap'
import ToastComponent from './components/ToastComponent'
import ButtonToggleComponent from './components/ButtonToggleComponent'
import InputImageComponent from './components/InputImageComponent'
import ProductModalComponent from './components/ProductModalComponent'
import UserModalComponent from './components/UserModalComponent'
import SelectStockComponent from './components/SelectStockComponent'
import SelectQuantityComponent from "./components/SelectQuantityComponent";

window.Vue = Vue

Vue.component('toast-component', ToastComponent)
Vue.component('button-toggle-component', ButtonToggleComponent)
Vue.component('input-image-component', InputImageComponent)
Vue.component('product-modal-component', ProductModalComponent)
Vue.component('user-modal-component', UserModalComponent)
Vue.component('select-stock-component', SelectStockComponent)
Vue.component('select-quantity-component', SelectQuantityComponent)

new Vue({
  el: '#app'
})
