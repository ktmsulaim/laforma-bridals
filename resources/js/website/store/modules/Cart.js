import _ from "lodash";

const state = {
    items: [],
};

const getters = {
    getCartItems(state) {
        return state.items;
    },
    getSubTotal() {
        if(state.items && state.items.length) {
            let price = 0;
            state.items.forEach(item => {
                price += item.net_price * item.quantity;
            })
            return price;
        }
    },
    getTotal(state) {
        if(state.items && state.items.length) {
            let price = 0;
            state.items.forEach(item => {
                if(item.special_price) {
                    price += item.special_price * item.quantity;
                } else {
                    price += item.net_price * item.quantity;
                }
            })

            return price;
        }
    }
};

const mutations = {
    setCart(state, data) {
        state.items = data;
    },
    addToCart(state, item) {
        state.items.push(item);

        localStorage.setItem('cartItems', JSON.stringify(state.items));
    },
    updateCart(state, item) {
        let cartItem;

        if(_.isEmpty(item.options)) {
            cartItem = state.items.find(ci => ci.product_id === item.product_id)
        } else {
            cartItem = state.items.find(ci => ci.product_id === item.product_id && _.isEqual(ci.options, item.options))
        }

        const index = state.items.indexOf(cartItem)

        if(index != -1) {
            state.items.splice(index, 1, item)
        }

        localStorage.setItem('cartItems', JSON.stringify(state.items));
    },
    removeFromCart(state, item) {
        const index = state.items.indexOf(item);

        if(index != -1) {
            state.items.splice(index, 1)
            localStorage.setItem('cartItems', JSON.stringify(state.items));
        }
    },
    clearCart(state) {
        localStorage.removeItem('cartItems')
        state.items = []
    },
};

const actions = {

};

export default {
    state, getters, mutations, actions
}