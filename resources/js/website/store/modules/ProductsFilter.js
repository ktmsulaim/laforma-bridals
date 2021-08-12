import _ from "lodash";

const state = {
    loading: false,
    categories: [],
    tags: [],
    filter: {
        selected: {
            categories: [],
            tags: [],
            price: null,
            attributes: null,
        }
    },
    mode: 'grid',
    sort: 'date'
};

const getters = {
    getLoading(state) {
        return state.loading;
    },
    getCategories(state) {
        return state.categories;
    },
    getTags(state) {
        return state.tags;
    },
    getFilters(state) {
        return state.filter.selected;
    },
    getMode(state) {
        return state.mode;
    },
    getSort(state) {
        return state.sort;
    }
};


const mutations = {
    setLoading(state, loading) {
        state.loading = loading;
    },
    setCategories(state, data) {
        state.categories = data;
    },
    setTags(state, data) {
        state.tags = data;
    },
    applyFilter(state, data) {
        state.filter.selected.categories = data.categories;
        state.filter.selected.tags = data.tags;
        state.filter.selected.price = data.price;
        state.filter.selected.attributes = data.attributes;
    },
    clearFilter(state) {
        state.filter.selected.categories = [];
        state.filter.selected.tags = [];
        state.filter.selected.price = null;
        state.filter.selected.attributes = null;
    },
    setMode(state, mode) {
        state.mode = mode;
    },
    setSort(state, sort) {
        state.sort = sort;
    }
};

const actions = {

};

export default {
    state, getters, mutations, actions
}