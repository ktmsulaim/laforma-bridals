<template>
  <div>
    <div class="d-flex justify-content-between align-items-center">
      <span>{{ getStatus }}</span>
      <span v-if="loading" class="mdi mdi-loading mdi-spin"></span>
    <span
        v-else
        @click="openModal"
    >
      <span class="mdi mdi-pencil-circle-outline icon"></span>
    </span>
    </div>

    <div id="booking-progress-modal" class="modal-demo">
      <button type="button" class="close" @click="closeModal">
        <span>&times;</span><span class="sr-only">Close</span>
      </button>
      <h4 class="custom-modal-title">Change progress</h4>
      <div class="custom-modal-text">
          <p>Select an option</p>
          <div class="form-group">
              <select class="form-control" id="status-options" v-model="status.selected">
                  <option  value="not_started">Not started</option>
                  <option  value="in_progress">In progress</option>
                  <option  value="finished">Finished</option>
              </select>
          </div>
        <div class="mt-2">
          <button
            type="button"
            class="btn btn-secondary"
            @click="closeModal"
          >
            Cancel
          </button>
          <button @click="updateStatus" :disabled="loading" class="btn btn-primary" type="submit">
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
  name: "BookingProgress",
  props: ["bookingId", "oldProgress"],
  data() {
    return {
      loading: false,
      status: {
          new: null,
          selected: null
      },
    };
  },
  computed: {
    getStatus() {
      if (this.status.new) {
        return this.status.new;
      } else {
        return this.oldProgress.text;
      }
    },
  },
  methods: {
    updateStatus() {
        if(!this.status.selected) {
            toastr.error('Select an option to update');
            return;
        }

        this.loading = true;

        axios.post(route('admin.bookings.progress', {booking: this.bookingId}), {progress: this.status.selected})
        .then(resp => {
            this.status.new = resp.data
            Custombox.modal.close()
            toastr.success('Progress updated', 'Success')
        })
        .catch(err => toastr.error('Unable to save the progress', 'Failed'))
        .finally(() => this.loading = false)
    },
    openModal() {
        let modal = new Custombox.modal({
          content: {
              effect: 'fadein',
              target: '#booking-progress-modal',
              id: 'booking-progress',
              close: true,
          }
      })

      modal.open();
    },
    closeModal() {
        Custombox.modal.close('booking-progress')
    }
  },
  mounted() {
      if(this.oldProgress && this.oldProgress.data) {
          this.status.selected = this.oldProgress.data;
      }
  }
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
