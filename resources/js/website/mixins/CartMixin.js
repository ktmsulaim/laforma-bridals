export default {
    data() {
        return {
            addToCartLoading: false,
        }
    },
    computed: {
        cart() {
            return this.$store.state.Cart.items;
        }
    },
    methods: {
        addToCart(product, quantity = 1) {
            if(product) {                
                if(this.cart) {
                    const item = this.cart.find(cartItem => cartItem.product_id == product.id);
                    if(item) {
                        if(item.quantity == product.qty) {
                            this.$toast.open({
                                message: 'Maximum count of quantity reached',
                                type: 'warning'
                            })
                            return;
                        }

                        this.$store.commit('updateCart', {
                            image: product.base_image,
                            name: product.name,
                            product_id: product.id,
                            quantity: item.quantity + quantity,
                            net_price: product.price.original,
                            special_price: product.special_price.original,
                            price: product.special_price.has_special_price ? product.special_price.formatted : product.price.formatted
                        });
                        this.$toast.open({
                            message: 'The product is already in the cart. Quantity updated!',
                            type: 'default',
                        })
                    } else {
                        this.$store.commit('addToCart', {
                            image: product.base_image,
                            name: product.name,
                            product_id: product.id,
                            quantity,
                            net_price: product.price.original,
                            special_price: product.special_price.original,
                            price: product.special_price.has_special_price ? product.special_price.formatted : product.price.formatted
                        });        
                        this.$toast.open({
                            message: 'The product has been added to cart',
                            type: 'info',
                        })
                    }
                }
            }
        }
    }
}