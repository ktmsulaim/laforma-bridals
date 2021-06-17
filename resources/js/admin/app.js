window._ = require('lodash')

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.token = $('meta[name="csrf-token"]').attr('content')

if(token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// require('../vendor/laravel-datagrid/laravel-datagrid');

import Vue from 'vue'
import VueSkeletonLoader from 'skeleton-loader-vue';
import VueFileAgent from 'vue-file-agent';
import VueFileAgentStyles from 'vue-file-agent/dist/vue-file-agent.css';

import VueQuillEditor from 'vue-quill-editor'

import 'quill/dist/quill.core.css' // import styles
import 'quill/dist/quill.snow.css' // for snow theme
import 'quill/dist/quill.bubble.css' // for bubble theme

import store from './store'



window.Vue = Vue
Vue.use(VueFileAgent);
Vue.component('vue-skeleton-loader', VueSkeletonLoader);
Vue.use(VueQuillEditor)


/**
 * -----------------------------------------------------
 * Components
 * -----------------------------------------------------
 */

import Card from './components/Card'
import FileManager from './components/FileManager'
import ProductsForm from './components/products/ProductsForm'
import Errors from './components/Errors'
import ListProducts from './components/products/ListProducts'

const app = new Vue({
    el: '#app',
    components: {
        Card,
        FileManager,
        ProductsForm,
        Errors,
        ListProducts
    },
    store
})