<template>
  <div>
    <div class="d-flex justify-content-between align-items-center">
      <span>{{ getStatus }}</span>
      <span v-if="loading" class="mdi mdi-loading mdi-spin"></span>
    <span
        v-else
        @click="openModal">
      <span class="mdi mdi-pencil-circle-outline icon"></span>
    </span>
    </div>

    <div id="order-status-modal" class="modal-demo">
      <button type="button" class="close" @click="closeModal">
        <span>&times;</span><span class="sr-only">Close</span>
      </button>
      <h4 class="custom-modal-title">Change order status</h4>
      <div class="custom-modal-text">
          <p>Select an order status to update</p>
          <div class="form-group">
              <select class="form-control" id="status-options" v-model="status.selected">
                  <option  value="pending">Pending</option>
                  <option  value="payment_pending">Payment Pending</option>
                  <option  value="on_hold">On hold</option>
                  <option  value="confirmed">Confirmed</option>
                  <option  value="processing">Processing</option>
                  <option  value="completed">Completed</option>
                  <option  value="cancelled">Cancelled</option>
                  <option  value="refunded">Refunded</option>
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
  name: "OrderStatus",
  props: ["orderId", "oldStatus"],
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
        return this.oldStatus.text;
      }
    },
  },
  methods: {
    updateStatus() {
        if(!this.status.selected) {
            toastr.error('Select a status to update');
            return;
        }

        this.loading = true;

        axios.post(route('admin.orders.status', {order: this.orderId}), {status: this.status.selected})
        .then(resp => {
            this.status.new = resp.data
            Custombox.modal.close('order-status')
            toastr.success('Order status updated', 'Success')
        })
        .catch(err => toastr.error('Unable to save the order status', 'Failed'))
        .finally(() => this.loading = false)
    },
    openModal() {
        let modal = new Custombox.modal({
          content: {
              effect: 'fadein',
              target: '#order-status-modal',
              id: 'order-status',
              close: true,
          }
      })

      modal.open();
    },
    closeModal() {
        Custombox.modal.close('order-status')
    }
  },
  mounted() {
      if(this.oldStatus && this.oldStatus.data) {
          this.status.selected = this.oldStatus.data;
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
