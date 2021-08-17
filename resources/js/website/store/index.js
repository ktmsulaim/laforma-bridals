import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import Cart from './modules/Cart'
import Auth from './modules/Auth'
import ProductsFilter from './modules/ProductsFilter'
import Reviews from './modules/Reviews'

export default new Vuex.Store({
    modules: {
        Cart,
        Auth,
        ProductsFilter,
        Reviews,
    }
})