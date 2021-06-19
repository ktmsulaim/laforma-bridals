import axios from "axios";

const state = {
    all: [],
    list: [],
    loading: false,
    selected: null
};

const getters = {
    getAll: (state) => state.all,
    getForSelect: (state) => {
        if(state.selected) {
            return state.list.filter(item => {
                const listItem = state.list.find(itemIt => itemIt.id == state.selected.id);
                if(listItem && listItem.children && listItem.children.length && listItem.children.includes(item.id)) {
                    return false;
                } else if(item.id == state.selected.id) {
                    return false;
                }
                return true;
            })
        } else {
            return state.list;
        }
    },
    getSelected: state => state.selected,
    getRelated: state => {
        if(state.selected) {
            
        }
    }
};

const mutations = {
    setAll(state, data) {
        state.all = data;
    },
    setList(state, data) {
        state.list = data;
    },
    addToList(state, data) {
        state.list.push(data)
    },
    select(state, data) {
        state.selected = data;
    }
};

const actions = {
    fetchCategories({commit, state}) {
        state.loading = true;
        axios.get(route('admin.categories.index', {list: true}))
        .then(resp => {
            if(resp.data && Object.keys(resp.data).length) {
                commit('setAll', resp.data.categories)
                commit('setList', resp.data.categoryList)
            }
        })
        .catch(err => console.error(err))
        .finally(() => {
            state.loading = false;
        })
    }
};

export default {
    state, getters, mutations, actions
}
