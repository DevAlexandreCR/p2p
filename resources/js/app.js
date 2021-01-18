import Vue from 'vue'
import './bootstrap'
import ToastComponent from "./components/ToastComponent"

window.Vue = Vue

Vue.component('toast-component', ToastComponent)

new Vue({
    el: '#app',
});
