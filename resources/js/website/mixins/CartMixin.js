import _ from "lodash";
import { mapGetters } from "vuex";
export default {
    data() {
        return { addToCartLoading: false, quantity: 1};
    },
    computed: {
        ...mapGetters({
            getTotal: "getTotal",
            getSubTotal: "getSubTotal",
            items: 'getCartItems'
        }),
        total() {
            return this.formatMoney(this.getTotal)
        },
        subTotal() {
            if(this.getSubTotal) {
                return this.formatMoney(this.getSubTotal)
            }
        },
        discount() {
            const diff = this.getTotal - this.getSubTotal;
            if(diff) {
                return this.formatMoney(diff)
            } else {
                return diff;
            }
        },
        checkoutUrl() {
            return route('checkout');
        }
        
    },
    methods: {
        addToCart(product, quantity = 1) {
            if (product) {
                if (quantity > product.qty) {
                    this.$toast.open({
                        message: "Maximum count of quantity reached",
                        type: "warning"
                    });

                    this.quantity = 1;

                    return;
                }

                if (product.options.has_options) {
                    let validOptions = true;
                    product.options.items.forEach(option => {
                        if (
                            option.is_required === 1 &&
                            (!this.selectedOptions ||
                                !Object.keys(this.selectedOptions).length ||
                                !this.selectedOptions[option.name])
                        ) {
                            validOptions = false;
                        }
                    });

                    if (!validOptions) {
                        this.$toast.open({
                            message: "Select the required options",
                            type: "error"
                        });

                        return;
                    }
                }

                let cartItemData = {
                    image: product.base_image,
                    name: product.name,
                    url: product.url,
                    product_id: product.id,
                    quantity,
                    net_price: this.productOriginalPrice
                        ? this.productOriginalPrice
                        : product.price.original,
                    special_price: this.productPrice
                        ? this.productPrice
                        : product.special_price.original,
                    price: product.special_price.has_special_price
                        ? this.productPriceFormatted
                        : this.productOriginalPriceFormatted,
                    options: Object.assign({}, this.selectedOptions)
                };

                if (!_.isEmpty(this.items)) {
                    let item;

                    if(product.options.has_options) {
                        item = this.items.find(
                            cartItem => cartItem.product_id == product.id && _.isEqual(cartItem.options, cartItemData.options)
                        );
                    } else {
                        item = this.items.find(
                            cartItem => cartItem.product_id == product.id
                        );
                    }


                    if (_.isEmpty(item)) {
                        let data = Object.assign({}, cartItemData);
                        this.$store.commit("addToCart", data);

                        this.$toast.open({
                            message: "The product has been added to cart",
                            type: "info"
                        });
                    } else {
                        let data = Object.assign({}, cartItemData);
                        
                        if (
                            item.quantity >= product.qty ||
                            item.quantity + quantity > product.qty
                        ) {
                            this.$toast.open({
                                message: "Maximum count of quantity reached",
                                type: "warning"
                            });
                            return;
                        }

                        data["quantity"] = item.quantity + quantity;
                        
                        this.$store.commit("updateCart", data);

                        this.$toast.open({
                            message:
                                "The product is already in the cart. Quantity updated!",
                            type: "default"
                        });

                    }
                } else {
                    let data = Object.assign({}, cartItemData);

                    this.$store.commit("addToCart", data);

                    this.$toast.open({
                        message: "The product has been added to cart",
                        type: "info"
                    });
                }
            }
        },
        removeFromCart(item) {
            this.$store.commit("removeFromCart", item);
        },
        updateQuantity(type) {
            if (type == "increase" && this.quantity < this.product.qty) {
                this.quantity++;
            } else if (type == "decrease" && this.quantity > 1) {
                this.quantity--;
            }
        },
        checkQuantity(max = null) {
            if (this.quantity < 0) {
                this.quantity = 1;
            }

            if (max && this.quantity > max) {
                this.quantity = max;
            }
        },
        resetSelectOptions() {
            this.selectedOptions = null;
        },
        checkProductVariant(cartItem) {
            if (
                cartItem &&
                cartItem.options &&
                Object.keys(cartItem.options).length &&
                this.selectedOptions
            ) {
                let status = _.isEqual(cartItem.options, this.selectedOptions);
                return status;
            }
        }
    }
};
