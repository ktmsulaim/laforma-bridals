import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import Cart from './modules/Cart'
import Auth from './modules/Auth'

export default new Vuex.Store({
    modules: {
        Cart,
        Auth
    }
})