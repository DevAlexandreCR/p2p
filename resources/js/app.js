import Vue from 'vue'
import './bootstrap'
import ToastComponent from './components/ToastComponent'
import ButtonToggleComponent from './components/ButtonToggleComponent'
import InputImageComponent from './components/InputImageComponent'
import ProductModalComponent from './components/ProductModalComponent'
import UserModalComponent from './components/UserModalComponent'
import SelectStockComponent from './components/SelectStockComponent'
import SelectQuantityComponent from './components/SelectQuantityComponent'
import OrderByComponent from './components/OrderByComponent'
import SwitchComponent from './components/SwitchComponent'
import BackButtonComponent from './components/BackButtonComponent'

window.Vue = Vue

Vue.component('toast-component', ToastComponent)
Vue.component('button-toggle-component', ButtonToggleComponent)
Vue.component('input-image-component', InputImageComponent)
Vue.component('product-modal-component', ProductModalComponent)
Vue.component('user-modal-component', UserModalComponent)
Vue.component('select-stock-component', SelectStockComponent)
Vue.component('select-quantity-component', SelectQuantityComponent)
Vue.component('order-by-component', OrderByComponent)
Vue.component('switch-component', SwitchComponent)
Vue.component('back-button-component', BackButtonComponent)

new Vue({
  el: '#app'
})
