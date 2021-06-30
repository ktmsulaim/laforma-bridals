import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import Cart from './modules/Cart'

export default new Vuex.Store({
    modules: {
        Cart
    }
})