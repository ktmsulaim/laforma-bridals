<template>
  <div>
    <button class="btn btn-default" @click="openModal">Change time</button>
    <modal
      name="changeBookingTimeModal"
      :adaptive="true"
      height="auto"
      :scrollable="true"
    >
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Change time</h5>
          <div class="form-group row align-items-end">
            <div class="col-lg-6">
              <label for="date">Check availability</label>
              <date-picker
                :disabled="loading || availability.loading"
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
                  loading || availability.loading || availability.status
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
              <div class="row align-items-end">
                <div class="col-lg-6">
                  <div>
                    <label for="time">Select a time to book</label>
                  </div>
                  <select
                    class="form-control"
                    id="time"
                    v-model="availability.selectedTime"
                    :disabled="loading"
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
                    @click="change"
                    :disabled="!validDateTime || loading"
                    class="btn_1"
                  >
                    <span v-if="loading"
                      ><span class="mdi mdi-loading mdi-spin"></span
                    ></span>
                    <span v-else>Change</span>
                  </button>
                </div>
              </div>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

import bookPackageMixin from "../../../mixins/bookPackageMixin";

export default {
  name: "ChangeTime",
  props: ["booking"],
  mixins: [bookPackageMixin],
  components:{
    DatePicker,
  },
  data() {
    return {
      loading: false,
    }
  },
  computed: {
    packages() {
      return this.booking.package;
    }
  },
  methods: {
    openModal() {
      this.$modal.show("changeBookingTimeModal");
    },
    change() {
      this.loading = true;
      axios.post(route('customer.book.change', {
        booking_id: this.booking.id,
        new_date: this.availability.selectedDate,
        new_time: this.availability.selectedTime,
      }))
      .then(resp => {
        this.$toast.open({
          message: 'Booking date and time has been changed!',
          type: 'success'
        })
        this.resetAvailabilityStatus();
        this.$modal.hide('changeBookingTimeModal')

        setTimeout(() => {
          window.location = route('customer.bookings.show', {booking: this.booking.id})
        }, 1000)
      })  
      .catch(err => {
        let message = err.response.data.error;
        
        this.$toast.open({
          message: message ? message : 'Unable to process the request',
          type: 'error',
        })

      })
      .finally(() => {
        this.loading = false;
      })
    }
  },
};
</script>

<style>
</style>