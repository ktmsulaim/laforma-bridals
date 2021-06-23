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
import VueQuillEditor from 'vue-quill-editor'
import VueSlugify from 'vue-slugify'
import Select2 from 'v-select2-component'
import VueSweetalert2 from 'vue-sweetalert2';
import JwPagination from 'jw-vue-pagination';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';


import 'quill/dist/quill.core.css' // import styles
import 'quill/dist/quill.snow.css' // for snow theme
import 'quill/dist/quill.bubble.css' // for bubble theme
import VueFileAgentStyles from 'vue-file-agent/dist/vue-file-agent.css';

import store from './store'



window.Vue = Vue
Vue.use(VueFileAgent);
Vue.use(VueQuillEditor)
Vue.use(VueSlugify)
Vue.use(Select2)
Vue.use(VueSweetalert2)

Vue.component('vue-skeleton-loader', VueSkeletonLoader);
Vue.component('jw-pagination', JwPagination)

Vue.mixin({
    methods: {
        slugify(text){
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/--+/g, '-'); // Replace multiple - with single -
        }
    }
})


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
import ListCategories from './components/categories/ListCategories'
import ListTags from './components/tags/ListTags'
import ListServices from './components/services/ListServices'
import ServicesForm from './components/services/ServicesForm'

Vue.component('file-manager', FileManager)

const app = new Vue({
    el: '#app',
    components: {
        Card,
        ProductsForm,
        Errors,
        ListProducts,
        ListCategories,
        ListTags,
        ListServices,
        ServicesForm
    },
    store
})

global.app = app;