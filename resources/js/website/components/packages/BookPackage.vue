<template>
  <loading v-if="loading"></loading>
  <div v-else-if="packages && razorpay_key_id">
    <div class="form-group row align-items-end">
      <div class="col-lg-6">
        <label for="date">Check availability</label>
        <date-picker
          :disabled="booking.loading || availability.loading"
          value-type="YYYY-MM-DD"
          format="dddd - DD MMM, YY"
          input-class="form-control"
          v-model="availability.selectedDate"
          :disabled-date="disabledDates"
          @change="resetAvailabilityStatus"
          @clear="resetAvailabilityStatus"
        ></date-picker>
      </div>
      <div class="col-lg-6 mt-2 mt-md-0">
        <button
          :disabled="
            booking.loading || availability.loading || availability.status
          "
          class="btn_1 gray"
          @click="checkAvailability"
        >
          <span v-if="availability.loading"
            ><span class="mdi mdi-loading mdi-spin"></span
          ></span>
          <span v-else>Check</span>
        </button>
      </div>
    </div>

    <div v-if="availability.status" class="mt-2">
      <div v-if="auth">
        <div class="row align-items-end">
          <div class="col-lg-6">
            <div>
              <label for="time">Select a time to book</label>
            </div>
            <select
              class="form-control"
              id="time"
              v-model="availability.selectedTime"
              :disabled="booking.loading"
            >
              <option :value="null">Select time</option>
              <option
                v-for="(slot, slotIndex) in availability.slots"
                :key="slotIndex"
                :value="slot"
              >
                {{ slot }}
              </option>
            </select>
          </div>
          <div class="col-lg-6 mt-2 mt-md-0">
            <button
              @click="book"
              :disabled="!validDateTime || booking.loading"
              class="btn_1"
            >
              <span v-if="booking.loading"
                ><span class="mdi mdi-loading mdi-spin"></span
              ></span>
              <span v-else>Book now</span>
            </button>
          </div>
        </div>
      </div>
      <div v-else>
        <button @click="showAuthForm" class="btn_1 gray">Sign in</button>
        <modal
          name="authForm"
          :adaptive="true"
          height="auto"
          :scrollable="true"
          transition="fade"
        >
          <div class="p-4">
            <auth type="login" :redirect="false"></auth>
          </div>
        </modal>
      </div>
    </div>

    <div class="mt-2">
      <p v-if="isShopOpen" :class="{ 'text-success': isShopOpen }">
        Shop is open
      </p>
      <p v-else :class="{ 'text-danger': !isShopOpen }">Shop is closed</p>
    </div>
  </div>
  <div v-else>
    <p>Sorry! Booking service is not available now!</p>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

import { mapGetters } from "vuex";

import Loading from "../Loading.vue";
import Auth from "../Auth.vue";

import BookPackageMixin from "../../mixins/bookPackageMixin";

export default {
  name: "BookPackage",
  props: ["package_id", "razorpay_key_id"],
  components: {
    DatePicker,
    Auth,
    Loading,
  },
  mixins: [BookPackageMixin],
  data() {
    return {
      loading: false,
      packages: null,
      booking: {
        loading: false,
        id: null,
      },
      data: {
        package_id: this.package_id,
        customer_id: null,
        date: null,
        time: null,
        progress: "not_started",
        status: "pending",
      },
      payment: {
        key: this.razorpay_key_id,
        amount: this.packages ? this.packages.booking_price.net_price * 100 : 0,
        currency: "INR",
        name: "La'forma bridals",
        description: "DESIGNERS MAKE OVER STUDIO",
        image: "/img/2.png",
        order_id: null,
        handler: (response) => {
          this.data.date = this.availability.selectedDate;
          this.data.time = this.availability.selectedTime;

          axios
            .post(route("customer.book"), this.data)
            .then((resp) => {
              let booking = resp.data;

              if (booking) {
                this.booking.id = booking.id;
              }

              return axios.post(route("customer.book.payment"), {
                booking_id: this.booking.id,
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                signature: response.razorpay_signature,
                type: "booking_charge",
                status: "success",
              });
            })
            .then((resp) => {
              let summary = resp.data.data;

              this.$swal({
                titleText: "Your booking has been processed",
                text: summary,
                icon: "success",
                allowOutsideClick: false,
                confirmButtonText: "Show",
                confirmButtonColor: "#a21d23",
              })
                .then((result) => {
                  if (result.isConfirmed) {
                    window.location = route("customer.bookings.show", {
                      booking: this.booking.id,
                    });
                  }
                })
                .catch((error) => {
                  console.error(error);
                  this.$swal(
                    "Sorry! Unable to prcess the request. Try again later",
                    "",
                    "error"
                  );
                  this.booking.loading = false;
                });
            })
            .catch((err) => {
              this.$toast.open({
                message: "Unable to process the request",
                type: "error",
              });
            })
            .finally(() => {
              this.availability.selectedDate = null;
              this.resetAvailabilityStatus();
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
            this.resetAvailabilityStatus();
          },
        },
      },
    };
  },
  computed: {
    ...mapGetters({
      auth: "authenticated",
      user: "authenticatedUser",
    }),
    isShopOpen() {
      return Settings.isShopOpen;
    },
  },
  methods: {
    fetchPackage() {
      this.loading = true;
      axios
        .get(route("packages.get", this.package_id))
        .then((resp) => (this.packages = resp.data.data))
        .catch((err) =>
          this.$toast.open({
            message: "Unable to fetch the package",
            type: "error",
          })
        )
        .finally(() => (this.loading = false));
    },
    showAuthForm() {
      this.$modal.show("authForm");
    },
    book() {
      if (this.validDateTime) {
        this.booking.loading = true;

        axios
          .post(
            route("customer.payment.razorpay.getOrder", { type: "package" }),
            { amount: this.packages.booking_price.net_price }
          )
          .then((resp) => {
            let razorpay_order = resp.data;

            this.payment.order_id = razorpay_order.id;

            let gateway = new Razorpay(this.payment);

            gateway.on("payment.failed", (response) => {
              this.$toast.open({
                message: response.error.description,
                type: "error",
              });

              this.loading = false;

              let payment_id = response.error.metadata.payment_id;

              console.log(response.error.code);
              console.log(response.error.description);
              console.log(response.error.source);
              console.log(response.error.step);
              console.log(response.error.reason);
              console.log(response.error.metadata.order_id);
              console.log(response.error.metadata.payment_id);
            });

            gateway.open();
          })
          .catch((err) => {
            this.booking.loading = false;

            this.$toast.open({
              message: "Unable to process the booking",
              type: "error",
            });
          });
      }
    },
  },
  watch: {
    auth(newVal, oldVal) {
      if (newVal) {
        this.$modal.hide("authForm");

        if (this.user) {
          this.data.customer_id = this.user.id;
          this.payment.prefill.name = this.user.name;
          this.payment.prefill.email = this.user.email;
          this.payment.prefill.contact = this.user.phone;
        }
      }
    },
  },
  created() {
    this.fetchPackage();

    if (this.user) {
      this.data.customer_id = this.user.id;
      this.payment.prefill.name = this.user.name;
      this.payment.prefill.email = this.user.email;
      this.payment.prefill.contact = this.user.phone;
    }
  },
};
</script>

<style>
</style>