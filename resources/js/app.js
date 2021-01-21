import Vue from 'vue'
import './bootstrap'
import ToastComponent from './components/ToastComponent'
import ButtonToggleComponent from "./components/ButtonToggleComponent";

window.Vue = Vue

Vue.component('toast-component', ToastComponent)
Vue.component('button-toggle-component', ButtonToggleComponent)

new Vue({
  el: '#app'
})
