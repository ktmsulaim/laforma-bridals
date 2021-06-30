<template>
  <div class="dropdown dropdown-cart">
    <a href="javascript:void(0)" class="cart_bt"><strong v-if="items && items.length">{{ items.length }}</strong></a>
    <div class="dropdown-menu">
      <div v-if="items && items.length">
        <ul>
          <li v-for="(item, index) in items" :key="index">
            <a href="product-detail-1.html">
              <figure>
                <img
                  :src="item.image"
                  :data-src="item.image"
                  alt=""
                  width="50"
                  height="50"
                  class="lazy"
                />
              </figure>
              <strong
                ><span>{{ item.quantity }} x {{ item.name }}</span
                >{{ item.price }}</strong
              >
            </a>
            <a href="javascript:void(0)" class="action" @click="removeFromCart(item)"><i class="ti-trash"></i></a>
          </li>
        </ul>
        <div class="total_drop">
          <div class="clearfix"><strong>Total</strong><span>{{ total }}</span></div>
          <a href="cart.html" class="btn_1 outline">View Cart</a
          ><a href="checkout.html" class="btn_1">Checkout</a>
        </div>
      </div>
      <div v-else>
        <p class="text-center text-muted m-0">Your cart is empty</p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: "Cart",
  computed: {
    ...mapGetters({
        'total': 'getTotal'
    }),
    items() {
        return this.$store.state.Cart.items;
    }
  },
  methods: {
      removeFromCart(item) {
          this.$store.commit('removeFromCart', item)
      }
  },
  created() {
      const cartItems = localStorage.getItem('cartItems')

      if(cartItems) {
          this.$store.commit('setCart', JSON.parse(cartItems))
      } else {
          this.$store.commit('setCart', [])
      }
  },
};
</script>

<style>
</style>