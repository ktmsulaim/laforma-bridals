window._ = require('lodash')

window.axios = require('axios');

window.moment = require('moment')

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
import VueHtmlToPaper from 'vue-html-to-paper';
import InputTag from 'vue-input-tag'
import VueSlimScroll from 'vue-slimscroll'

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
Vue.use(VueHtmlToPaper);
Vue.use(VueSlimScroll)

Vue.component('vue-skeleton-loader', VueSkeletonLoader);
Vue.component('jw-pagination', JwPagination)
Vue.component('input-tag', InputTag)

Vue.mixin({
    methods: {
        slugify(text){
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/--+/g, '-'); // Replace multiple - with single -
        },
        formatMoney(value) {
            const formatter = new Intl.NumberFormat('en-Us', {
                style: 'currency',
                currency: 'INR'
            })

            return formatter.format(value);
        }
    }
})


/**
 * -----------------------------------------------------
 * Components
 * -----------------------------------------------------
 */
import Notifications from './components/layout/Notifications'

import Card from './components/Card'
import FileManager from './components/FileManager'
import ProductsForm from './components/products/ProductsForm'
import Errors from './components/Errors'
import ListProducts from './components/products/ListProducts'
import ListCategories from './components/categories/ListCategories'
import ListTags from './components/tags/ListTags'
import ListPackages from './components/packages/ListPackages'
import PackagesForm from './components/packages/PackagesForm'
import ListJobs from './components/jobs/ListJobs'
import JobForm from './components/jobs/JobForm'
import ListMedia from './components/media/ListMedia'
import ListCustomers from './components/customers/ListCustomers'
import ListOrders from './components/orders/ListOrders'
import CartItemOptions from '../website/components/cart/CartItemOptions'
import PrintInvoice from './components/orders/PrintInvoice'
import OrderStatus from './components/orders/OrderStatus'
import ListTransactions from './components/transactions/ListTransactions'
import ListBookings from './components/bookings/ListBookings'
import BookingStatus from './components/bookings/BookingStatus'
import BookingProgress from './components/bookings/BookingProgress'

Vue.component('file-manager', FileManager)
Vue.component('errors', Errors)
Vue.component('cart-item-options', CartItemOptions)
Vue.component('print-invoice', PrintInvoice)
Vue.component('order-status', OrderStatus)

const app = new Vue({
    el: '#app',
    components: {
        Notifications,

        Card,
        ProductsForm,
        ListProducts,
        ListCategories,
        ListTags,
        ListPackages,
        PackagesForm,
        ListJobs,
        JobForm,
        ListMedia,
        ListCustomers,
        ListOrders,
        ListTransactions,
        ListBookings,
        BookingStatus,
        BookingProgress
    },
    store
})

global.app = app;