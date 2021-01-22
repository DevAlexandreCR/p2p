import Vue from 'vue'
import './bootstrap'
import ToastComponent from './components/ToastComponent'
import ButtonToggleComponent from "./components/ButtonToggleComponent";
import InputImageComponent from "./components/InputImageComponent";

window.Vue = Vue

Vue.component('toast-component', ToastComponent)
Vue.component('button-toggle-component', ButtonToggleComponent)
Vue.component('input-image-component', InputImageComponent)

new Vue({
  el: '#app'
})
