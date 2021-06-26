const state = {
    edit: {
        status: false,
        selectAll: false,
        selected: []
    }
};

const getters = {
    
};

const mutations = {
    selectImage(state, value) {
        const index = state.edit.selected.indexOf(value);

        if(typeof state.edit.selected[index] === 'undefined') {
            state.edit.selected.push(value);
        } else {
            state.edit.selected.splice(index, 1);
        }
    },
    changeEditStatus(state, data){
        if(Object.keys(data).includes('key') && data.key) {
            state.edit[data.key] = data.status;
        } else {
            if(data.status === true) {
                state.edit.status = true;
            } else {
                state.edit.status = false;
                state.edit.selectAll = false;
                state.edit.selected = [];
            }
        }
    },
    selectAll(state, selected) {
        state.edit.selected = selected;
    }
};

const actions = {

};

export default {
    state, getters, mutations, actions
}