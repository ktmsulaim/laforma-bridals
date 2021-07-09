import _ from "lodash";

const state = {
    auth: false,
    authUser: null
};

const getters = {
    authenticated(state) {
        return state.auth;
    },
    authenticatedUser(state) {
        return state.authUser;
    }
};

const mutations = {
    authenticate(state, user) {
        if(!_.isEmpty(user)) {
            state.auth = true;
            state.authUser = user;
        }
    },
    logout(state) {
        state.auth = false;
        state.authUser = null;
    }
};

const actions = {

};

export default {
    state, getters, mutations, actions
}