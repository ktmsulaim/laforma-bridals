require('./bootstrap')

import Vue from 'vue'
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueSkeletonLoader from 'skeleton-loader-vue';
import StarRating from 'vue-star-rating'
import store from './store'
import vmodal from 'vue-js-modal'

window.Vue = Vue;
Vue.use(VueToast)
Vue.use(vmodal)

Vue.component('vue-skeleton-loader', VueSkeletonLoader);
Vue.component('start-rating', StarRating);

Vue.mixin({
    methods: {
        formatMoney(value) {
            if(value) {
                const formatter = new Intl.NumberFormat('en-Us', {
                    style: 'currency',
                    currency: 'INR'
                })
    
                return formatter.format(value);
            }
        }
    },
})

/**
 * ----------------------------------------------------
 * Components
 * ----------------------------------------------------
 */
import Auth from './components/Auth'
import FeaturedProducts from './components/home/FeaturedProducts'
import NoData from './components/NoData'
import SingleProduct from './components/products/SingleProduct'
import Cart from './components/Cart'
import CartIndex from './components/cart/Index'

Vue.component('no-data', NoData)


const app = new Vue({
    el: '#app',
    components: {
        Auth,
        FeaturedProducts,
        SingleProduct,
        Cart,
        CartIndex
    },
    store
});
