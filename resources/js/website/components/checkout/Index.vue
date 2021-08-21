<template>
  <div v-if="items && items.length" class="row">
    <div class="col-lg-5">
      <div class="step first">
        <h3>
          <span v-if="authenticated">Address</span>
          <span v-else>Sign in or sign up</span>
        </h3>
      </div>
      <address-selector
        @selectAddress="updateAddress"
        v-if="authenticated"
      ></address-selector>
      <auth v-else type="login" :redirect="false"></auth>
      <div class="mt-3">
        <textarea
          class="form-control"
          id="note"
          placeholder="Additional notes"
          v-model="data.note"
          rows="4"
        ></textarea>
      </div>
    </div>
    <div class="col-md-3">
      <div class="step">
        <h3>Payment method</h3>
      </div>
      <div class="card">
        <div class="card-body" v-if="hasPaymentMethods">
          <div v-if="hasCashOnDelivery" class="form-group">
            <label for="cod" class="container_radio">
              <input
                type="radio"
                v-model="data.payment_method"
                value="cod"
                id="cod"
                name="payment_method"
              />
              Cash On Delivery
              <span class="checkmark"></span>
            </label>
            <p>Pay with cash upon delivery.</p>
          </div>
          <div v-if="hasRazorpay" class="form-group">
            <label for="razorpay" class="container_radio">
              <input
                type="radio"
                v-model="data.payment_method"
                value="razorpay"
                id="razorpay"
                name="payment_method"
              />
              Razorpay
              <span class="checkmark"></span>
            </label>
            <p>
              Pay securely by Credit or Debit card or Internet Banking through
              Razorpay.
            </p>
          </div>
        </div>
        <div v-else class="card-body">
          <p>No payment method was configured</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="step last">
        <h3>Order summary</h3>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="cart-items">
            <ul class="cart-items-list">
              <li v-for="(item, index) in items" :key="index">
                <div>
                  <span>{{ item.name }}</span> <b>x{{ item.quantity }}</b>
                </div>
                <div>
                  <div class="price_box">
                    <span class="new_price">
                      <span>{{ item.price }}</span>
                    </span>
                    <span v-if="item.special_price" class="old_price">{{
                      formatMoney(item.net_price)
                    }}</span>
                  </div>
                </div>
              </li>
            </ul>
            <hr />
            <ul class="cart-items-list">
              <li>
                <b>Sub total</b>
                <b>{{ subTotal }}</b>
              </li>
              <li>
                <b>Discount</b>
                <b>{{ discount }}</b>
              </li>
              <li>
                <b>Shipping fee</b>
                <b>₹0.00</b>
              </li>
            </ul>
            <hr />
            <div class="total">
              <span>Total</span>
              <span class="amount">{{ total }}</span>
            </div>
            <div class="mt-4">
              <button
                :disabled="loading"
                @click="placeOrder"
                class="btn_1 full-width"
              >
                <span v-if="loading"
                  ><span class="mdi mdi-loading mdi-spin"></span>
                  Processing</span
                >
                <span v-else-if="data.payment_method == 'cod'"
                  >Place order</span
                >
                <span v-else-if="data.payment_method == 'razorpay'"
                  >Confirm and pay</span
                >
                <span v-else>Place order</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="row mt-3">
    <div class="col-lg-6 mx-auto">
      <div class="box_account">
        <no-data type="items"></no-data>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Auth from "../Auth.vue";
import AddressSelector from "./AddressSelector.vue";
import CartMixin from "../../mixins/CartMixin";
export default {
  name: "CheckoutIndex",
  props: ["razorpay_key_id"],
  data() {
    return {
      loading: false,
      ordered: false,
      ordered_id: null,
      razorpay: {
        gateway: null,
        order_id: null,
        payment_id: null,
        attepmted: false,
      },
      data: {
        customer_id: null,
        address_id: null,
        sub_total: 0,
        shipping_fee: 0,
        discount: 0,
        total: 0,
        payment_method: null,
        products: [],
        note: null,
        status: "pending",
      },
      payment: {
        key: this.razorpay_key_id,
        amount: 0,
        currency: "INR",
        name: "La'forma bridals",
        description: "DESIGNERS MAKE OVER STUDIO",
        image: "/img/2.png",
        order_id: null,
        handler: (response) => {
          
          axios
            .post(route("customer.placeorder", this.data))
            .then((resp) => {
                let order = resp.data;
                this.ordered_id = order.id;
                this.ordered = true;

              return axios.post(
                route("customer.payment.razorpay.makePayment"),
                {
                  order_id: order.id,
                  razorpay_order_id: response.razorpay_order_id,
                  signature: response.razorpay_signature,
                  transaction_id: response.razorpay_payment_id,
                  payment_method: "razorpay",
                  status: "success",
                }
              );
            })
            .then((resp) => {
              this.$swal({
                titleText: "Your order has been placed",
                text: `Order ID is: #${this.ordered_id}`,
                icon: "success",
                allowOutsideClick: false,
                confirmButtonText: "Show",
                confirmButtonColor: "#a21d23",
              })
                .then((result) => {
                  if (result.isConfirmed) {
                    window.location = route("customer.orders.show", {
                      order: this.ordered_id,
                    });
                  }
                })
                .catch((error) => {
                  console.error(error);
                  this.$swal(
                    "Sorry! Unable to place the order. Try again later",
                    "",
                    "error"
                  );
                  this.loading = false;
                });

              this.$store.commit("clearCart");
            })
            .catch((err) => {
              this.$toast.open({
                message: "Unable to complete payment",
                type: "error",
              });
              this.loading = false;
            });
        },
        prefill: {
          name: null,
          email: null,
          contact: null,
        },
        theme: {
          color: "#a21d23",
        },
        modal: {
          ondismiss: () => {
            this.loading = false;
          },
        },
      },
    };
  },
  mixins: [CartMixin],
  components: {
    Auth,
    AddressSelector,
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      user: "authenticatedUser",
    }),
    totalInPaise() {
      return this.getTotal * 100;
    },
    hasCashOnDelivery() {
      return Settings.enable_cash_on_delivery === "enable";
    },
    hasRazorpay() {
      return Settings.enable_razorpay === "enable";
    },
    hasPaymentMethods() {
      return this.hasRazorpay || this.hasCashOnDelivery;
    },
  },
  methods: {
    updateAddress(value) {
      if (value) {
        this.data.address_id = value.id;
      }
    },
    validate() {
      let hasError = false;
      let message = null;
      if (!this.data.payment_method) {
        hasError = true;
        message = "Please choose a payment method to continue";
      } else if (!this.data.customer_id) {
        hasError = true;
        message = "User must have logged in";
      } else if (!this.data.address_id) {
        hasError = true;
        message = "Please select atleast one address";
      } else if (_.isEmpty(this.data.products)) {
        hasError = true;
        message = "Your cart seems to be empty";
      }

      if (hasError) {
        this.$toast.open({
          message,
          type: "error",
        });
        return;
      }
    },
    placeOrder() {
      this.validate();

      this.loading = true;

      if (this.data.payment_method === "razorpay") {
        this.data.status = "payment_pending";
      }

      if (this.data.payment_method === "cod") {
        axios
          .post(route("customer.placeorder"), this.data)
          .then((resp) => {
            let order = resp.data;
            this.ordered = true;

            this.$swal({
              titleText: "Your order has been placed",
              text: `Your order ID is: #${order.id}`,
              icon: "success",
              allowOutsideClick: false,
              confirmButtonText: "Show",
              confirmButtonColor: "#a21d23",
            })
              .then((result) => {
                if (result.isConfirmed) {
                  window.location = route("customer.orders.show", {
                    order: order.id,
                  });
                }
              })
              .catch((error) => {
                console.error(error);
                this.$swal(
                  "Sorry! Unable to place the order. Try again later",
                  "",
                  "error"
                );
              });

            // Clear cart
            this.$store.commit("clearCart");
          })
          .catch((err) => {
            let message = err.response.data.error;
            this.$toast.open({
              message: message ? message : "Unable to place order",
              type: "error",
            });
          })
          .finally(() => (this.loading = false));
      } else if (
        this.data.payment_method === "razorpay" &&
        !this.razorpay.attepmted
      ) {
        axios
          .post(route("customer.placeorder.nextid"))
          .then((resp) => {
            let nextOrderID = resp.data;

            this.ordered_id = nextOrderID;

            return axios.post(
              route("customer.payment.razorpay.getOrder", { type: "product" }),
              {
                order_id: nextOrderID,
                amount: this.data.total,
              }
            );
          })
          .then((resp) => {
            let order = resp.data;

            this.razorpay.order_id = order.id;
            this.razorpay.attepmted = true;

            this.payment.order_id = order.id;

            this.razorpay.gateway = new Razorpay(this.payment);

            this.razorpay.gateway.on("payment.failed", (response) => {
              this.$toast.open({
                message: response.error.description,
                type: "error",
              });

              this.razorpay.payment_id = response.error.metadata.payment_id;

              // console.log(response.error.code);
              // console.log(response.error.description);
              // console.log(response.error.source);
              // console.log(response.error.step);
              // console.log(response.error.reason);
              // console.log(response.error.metadata.order_id);
              // console.log(response.error.metadata.payment_id);
            });

            this.razorpay.gateway.open();
          })
          .catch((err) => {
            let error = err.response.data.error;
            let message;
            if (error) {
              message = error;
            } else {
              message = "Unable to place order. Try again later.";
            }

            this.loading = false;

            this.$toast.open({
              message,
              type: "error",
            });
          });
      }
      
    },
  },
  watch: {
    items(newVal, oldVal) {
      if (_.isEmpty(newVal) && !this.ordered) {
        this.$toast.open({
          message: "Your cart is empty",
          type: "warning",
        });

        window.location = route("cart");
      }
    },
    user(newVal) {
      if(newVal && !_.isEmpty(newVal)) {
        this.data.customer_id = newVal.id;
        this.payment.prefill.name = newVal.name
        this.payment.prefill.email = newVal.email
        this.payment.prefill.phone = newVal.phone
      }
    }
  },
  created() {
    if (this.user) {
      this.data.customer_id = this.user.id;
    }

    this.data.sub_total = this.getSubTotal;
    this.data.total = this.getTotal;
    this.data.products = this.items;
    this.data.discount = this.discountNetPrice;

    if (this.totalInPaise) {
      this.payment.amount = this.totalInPaise;
    }

    if (this.user) {
      this.payment.prefill.name = this.user.name;
      this.payment.prefill.email = this.user.email;
      this.payment.prefill.contact = this.user.phone;
    }
  },
  beforeCreate() {
    if (_.isEmpty(this.$store.state.Cart.items)) {
      this.$toast.open({
        message: "Add any products to the cart to continue",
        type: "error",
      });
      window.location = route("website.index");
    }
  },
};
</script>

<style>
</style>