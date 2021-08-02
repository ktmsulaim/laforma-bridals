<template>
  <div>
    <div class="d-flex justify-content-between align-items-center">
      <span>{{ getStatus }}</span>
      <span v-if="loading" class="mdi mdi-loading mdi-spin"></span>
      <span
        v-else
        @click="openStatusModal"
      >
        <span class="mdi mdi-pencil-circle-outline icon"></span>
      </span>
    </div>

    <div id="booking-status-modal" class="modal-demo">
      <button type="button" class="close" @click="closeStatusModal">
        <span>&times;</span><span class="sr-only">Close</span>
      </button>
      <h4 class="custom-modal-title">Change booking status</h4>
      <div class="custom-modal-text">
        <p>Select an booking status to update</p>
        <div class="form-group">
          <select
            class="form-control"
            id="status-options"
            v-model="status.selected"
          >
            <option value="pending">Pending</option>
            <option value="booking_charge_pending">
              Booking charge Pending
            </option>
            <option value="full_amount_pending">Booked</option>
            <option value="completed">Completed</option>
            <option value="on_hold">On hold</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <div class="mt-2">
          <button
            type="button"
            class="btn btn-secondary"
            onclick="Custombox.modal.close();"
          >
            Cancel
          </button>
          <button
            @click="updateStatus"
            :disabled="loading"
            class="btn btn-primary"
            type="submit"
          >
            <span v-if="loading">
              <span class="mdi mdi-loading mdi-spin"></span> Processing
            </span>
            <span v-else>Save</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BookingStatus",
  props: ["bookingId", "oldStatus"],
  data() {
    return {
      loading: false,
      status: {
        new: null,
        selected: null,
      }
    };
  },
  computed: {
    getStatus() {
      if (this.status.new) {
        return this.status.new;
      } else {
        return this.oldStatus.text;
      }
    },
  },
  methods: {
    updateStatus() {
      if (!this.status.selected) {
        toastr.error("Select a status to update");
        return;
      }

      this.loading = true;

      axios
        .post(route("admin.bookings.status", { booking: this.bookingId }), {
          status: this.status.selected,
        })
        .then((resp) => {
          this.status.new = resp.data;
          Custombox.modal.close('booking-status');
          toastr.success("Booking status updated", "Success");
        })
        .catch((err) =>
          toastr.error("Unable to save the booking status", "Failed")
        )
        .finally(() => (this.loading = false));
    },
    openStatusModal() {
        let modal = new Custombox.modal({
          content: {
              effect: 'fadein',
              target: '#booking-status-modal',
              id: 'booking-status',
              close: true,
          }
      })

      modal.open();
    },
    closeStatusModal() {
        Custombox.modal.close('booking-status')
    }
  },
  mounted() {
    if (this.oldStatus && this.oldStatus.data) {
      this.status.selected = this.oldStatus.data;
    }
  },
};
</script>

<style>
.icon {
  color: #999;
}

.icon:hover {
  color: #444;
  cursor: pointer;
}
</style>
