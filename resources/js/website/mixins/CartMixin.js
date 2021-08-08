import _ from "lodash";
import { mapGetters } from "vuex";
export default {
    data() {
        return { 
            addToCartLoading: false,
            quantity: 1,
        };
    },
    computed: {
        ...mapGetters({
            getTotal: "getTotal",
            getSubTotal: "getSubTotal",
            items: 'getCartItems',
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
            if(this.discountNetPrice) {
                return this.formatMoney(this.discountNetPrice)
            } else {
                return '₹0.00';
            }
        },
        discountNetPrice() {
            const diff = this.getTotal - this.getSubTotal;
            if(diff) {
                return diff;
            } else {
                return 0;
            }
        },
        checkoutUrl() {
            return route('checkout');
        },
        productQuantity() {
            return this.product.qty;
        }
    },
    methods: {
        addToCart(product, quantity = 1) {
            if (product) {

                if(!product.is_orderable){
                    this.$toast.open({
                        message: 'Sorry! This product can\'t be ordered',
                        type: 'error'
                    });

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

                if (quantity > product.qty) {
                    this.$toast.open({
                        message: "Maximum count of quantity reached",
                        type: "warning"
                    });

                    this.quantity = 1;

                    return;
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
                    special_price: product.special_price.has_special_price && this.productPrice
                        ? this.productPrice
                        : (product.special_price.has_special_price ? product.special_price.original : 0),
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

            this.quantity = 1;
        },
        removeFromCart(item) {
            this.$store.commit("removeFromCart", item);
        },
        updateQuantity(type) {
            let qty = this.product.qty;

            this.checkQuantity(qty);

            if (type == "increase" && this.quantity < qty) {
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
