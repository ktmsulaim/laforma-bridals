const state = {
    errors: {}
};

const getters = {
    getErrors(state) {
        return state.errors;
    }
};

const mutations = {
    setErrors(state, data) {
        state.errors = data;
    },
    setSingleError(state, data) {
        state.errors[data.key] = data.value
    },
    resetErrors(state, data) {
        state.errors = {};
    },
    removeError(state, data) {
        delete state.errors[data.key]
    }
};

const actions = {
    assignErrors({commit}, data) {
        commit('setErrors', data)
    },
    assignSingleError({commit}, data){
        commit('setSingleError', data);
    }
};

export default {
    state, getters, mutations, actions
}