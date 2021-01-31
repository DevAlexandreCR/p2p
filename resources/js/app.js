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
import PaymentGatewaysComponent from './components/PaymentGatewaysComponent'
import ButtonToggleModalComponent from "./components/ButtonToggleModalComponent";

window.Vue = Vue
window.EventBus = new Vue()

new Vue({
  el: '#app',
  components: {
    ToastComponent,
    ButtonToggleComponent,
    InputImageComponent,
    ProductModalComponent,
    UserModalComponent,
    SelectStockComponent,
    SelectQuantityComponent,
    OrderByComponent,
    SwitchComponent,
    BackButtonComponent,
    PaymentGatewaysComponent,
    ButtonToggleModalComponent
  }
})
