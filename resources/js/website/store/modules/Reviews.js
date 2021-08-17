import axios from "axios";

const state = {
    reviews: []
};

const getters = {
    getReviews(state) {
        return state.reviews;
    }
};

const mutations = {
    setReviews(state, data) {
        state.reviews = data;
    },
    addToReviews(state, review) {
        state.reviews.data.unshift(review)
    }
};

const actions = {};

export default {state, getters, mutations, actions}
