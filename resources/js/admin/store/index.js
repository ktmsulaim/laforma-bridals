import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import Errors from './modules/Errors'
import Categories from './modules/Categories'


export default new Vuex.Store({
    state: {
        auth: {
            admin: false
        }
    },
    modules: {
        Errors,
        Categories
    }
})