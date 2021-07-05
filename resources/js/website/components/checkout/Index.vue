<template>
  <div class="row">
      <div class="col-lg-6">
          <div class="step first">
            <h3>Address</h3>
          </div>
      </div>
      <div class="col-md-3">
          <div class="step">
            <h3>Payment method</h3>
          </div>
      </div>
      <div class="col-md-3">
          <div class="step last">
            <h3>Order summary</h3>
          </div>
      </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: "CheckoutIndex",
    computed: {
        ...mapGetters({
            cartItems: 'getCartItems'
        })
    },
    created() {
        if(_.isEmpty(this.cartItems)) {
            this.$toast.open({
                message: 'Add any products to the cart to continue',
                type: 'error'
            })
            window.location = route('website.index')
        }
    }
}
</script>

<style>

</style>