<template>
  <div class="ml-2">
      <button class="btn btn-danger" @click="cancel">Cancel booking</button>
  </div>
</template>

<script>
export default {
    name: 'CancelBooking',
    props: ['booking'],
    methods: {
        cancel() {
            this.$swal({
                titleText: 'Are you sure?',
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                confirmButtonColor: '#ff5b5b',
            })
            .then(resp => {
                if(resp.isConfirmed) {
                    axios.post(route('customer.book.cancel', {booking: this.booking.id}))
                    .then(resp => {
                        this.$toast.open({
                            message: 'The booking has been cancelled!',
                            type: 'success'
                        })
                    })
                    .catch(err => {
                        let message = err.response.data.error;

                        this.$toast.open({
                            message: message ? message : 'Unable to process the request',
                            type: 'error'
                        })
                    })
                    .finally(() => {
                        setInterval(() => {
                            window.location.reload()
                        }, 1000)
                    })
                }
            })
            .catch(err => {
                this.$swal('Sorry! Unable to cancel the booking. Try again later', '', 'error')
            })
        }
    }
}
</script>

<style>

</style>