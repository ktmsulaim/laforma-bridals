require('./bootstrap')

import Vue from 'vue'
import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

window.Vue = Vue;
Vue.use(VueToast)

/**
 * ----------------------------------------------------
 * Components
 * ----------------------------------------------------
 */
import Auth from './components/Auth'

const app = new Vue({
    el: '#app',
    components: {
        Auth
    }
});
