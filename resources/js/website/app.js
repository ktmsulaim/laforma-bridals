require("./bootstrap");
import _ from "lodash";

import Vue from "vue";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import VueSkeletonLoader from "skeleton-loader-vue";
import StarRating from "vue-star-rating";
import store from "./store";
import vmodal from "vue-js-modal";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import PerfectScrollbar from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";

window.Vue = Vue;
Vue.use(VueToast);
Vue.use(vmodal);
Vue.use(VueSweetalert2);
Vue.use(PerfectScrollbar);

Vue.component("vue-skeleton-loader", VueSkeletonLoader);
Vue.component("start-rating", StarRating);

Vue.mixin({
    methods: {
        formatMoney(value) {
            if (value) {
                const formatter = new Intl.NumberFormat("en-Us", {
                    style: "currency",
                    currency: "INR"
                });

                return formatter.format(value);
            }
        },
        isEmpty(obj) {
            return _.isEmpty(obj);
        },
        str_limit(value, size) {
            if (!value) 
                return "";
            
            value = value.toString();

            if (value.length <= size) {
                return value;
            }
            return value.substr(0, size) + "...";
        }
    }
});

/**
 * ----------------------------------------------------
 * Components
 * ----------------------------------------------------
 */
import Auth from "./components/Auth";
import AccountBar from "./components/auth/AccountBar";

import FeaturedProducts from "./components/home/FeaturedProducts";
import Packages from "./components/home/Packages";
import BookPackage from "./components/packages/BookPackage";
import ShowFeatures from "./components/packages/ShowFeatures";

import NoData from "./components/NoData";
import Product from "./components/Product";
import ProductVertical from "./components/ProductVertical";
import SingleProduct from "./components/products/SingleProduct";
import Price from "./components/Price";
import ProductsIndex from "./components/products/ProductsIndex";
import ProductsToolBox from "./components/products/ProductsToolBox";

import Cart from "./components/Cart";
import CartItemOptions from "./components/cart/CartItemOptions";
import CartIndex from "./components/cart/Index";
import CheckoutIndex from "./components/checkout/Index";

import CustomerAddress from "./components/customer/addresses/CustomerAddress";
import SingleAddress from "./components/customer/addresses/SingleAddress";
import ListOrders from "./components/customer/orders/ListOrders";
import ListBookings from "./components/customer/bookings/ListBookings";
import ChangeTime from "./components/customer/bookings/ChangeTime";
import CancelBooking from "./components/customer/bookings/CancelBooking";

import ListReviews from "./components/customer/reviews/ListReviews";
import ReviewActions from './components/customer/reviews/ReviewActions'

import ListWishlist from './components/customer/wishlist/ListFavoriteProducts'

Vue.component("single-address", SingleAddress);
Vue.component("cart-item-options", CartItemOptions);
Vue.component("no-data", NoData);
Vue.component("pagination", require("laravel-vue-pagination"));

const app = new Vue({
    el: "#app",
    components: {
        Auth,
        AccountBar,
        FeaturedProducts,
        Packages,
        SingleProduct,
        Price,
        Product,
        ProductVertical,
        ProductsIndex,
        ProductsToolBox,
        Cart,
        CartIndex,
        CheckoutIndex,
        CustomerAddress,
        ListOrders,
        BookPackage,
        ShowFeatures,
        ListBookings,
        ChangeTime,
        CancelBooking,
        ListReviews,
        ReviewActions,
        ListWishlist,
    },
    store
});

window.$app = app;
