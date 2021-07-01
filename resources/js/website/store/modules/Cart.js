const state = {
    items: [],
};

const getters = {
    getCartItems(state) {
        return state.items;
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

            const formatter = new Intl.NumberFormat('en-Us', {
                style: 'currency',
                currency: 'INR'
            })

            return formatter.format(price);
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
        const cartItem = state.items.find(ci => ci.product_id === item.product_id)
        const index = state.items.indexOf(cartItem)

        if(index != -1) {
            state.items.splice(index, 1, item)
        }

        localStorage.setItem('cartItems', JSON.stringify(state.items));
    },
    removeFromCart(state, item) {
        const cartItem = state.items.find(ci => ci.product_id === item.product_id)
        const index = state.items.indexOf(cartItem);

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