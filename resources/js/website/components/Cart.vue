<template>
  <div class="dropdown dropdown-cart cart-drawer">
    <span @click="toggleCartDrawer(true)" class="cart-drawer-trigger"
      ><strong v-if="hasItems">{{ items.length }}</strong></span
    >
    <drawer :exist="true" direction="right" ref="cartDrawer">
      <div class="cart-drawer-title">
        <span class="title">Cart</span>
        <span class="mdi mdi-close" @click="toggleCartDrawer(false)"></span>
      </div>
      <div class="cart-drawer-body" ref="cartDrawerBody">
        <div v-if="hasItems">
          <perfect-scrollbar :style="`height: ${scrollBarHeight}px`">
            <ul class="cart-items">
              <li v-for="(item, index) in items" :key="index" class="cart-item">
                <div class="cart-item-image">
                  <a :href="item.url">
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
                  </a>
                </div>
                <div class="cart-item-data">
                  <a :href="item.url">
                    <strong>
                      <span class="name">
                        {{ item.name }}
                      </span>
                    </strong>
                  </a>
                  <div v-if="!isEmpty(item.options)" class="options">
                    <span
                      v-for="(option, key) in Object.entries(item.options)"
                      :key="key"
                      class="option"
                    >
                      <b>{{ option[0] }}</b
                      >:
                      <span
                        v-if="option[0] === 'Color'"
                        :style="`background-color: ${option[1]}`"
                        class="color-badge"
                      ></span>
                      <span v-else>{{ option[1] }}</span>
                    </span>
                  </div>
                  <div class="price">
                    <span class="qty">{{ item.quantity }} x </span>
                    <span class="price">{{ item.price }}</span>
                  </div>
                </div>
                <span class="action" @click="removeFromCart(item)"
                  ><i class="mdi mdi-trash-can"></i
                ></span>
              </li>
            </ul>
          </perfect-scrollbar>
          <div class="cart-bottom" ref="cartDrawerBottom">
            <div class="sub-total">
              <strong class="price-text">Sub total</strong
              ><span class="price-value">{{ total }}</span>
            </div>
            <div class="actions">
              <a :href="cartUrl" class="btn_1 outline">View Cart</a>
              <a :href="checkoutUrl" class="btn_1">Checkout</a>
            </div>
          </div>
        </div>
        <div v-else>
          <p class="text-center text-muted mt-2">Your cart is empty</p>
        </div>
      </div>
    </drawer>
  </div>
</template>

<script>
import CartMixin from "../mixins/CartMixin";
import Drawer from "./Drawer.vue";

export default {
  name: "Cart",
  mixins: [CartMixin],
  components: {
    Drawer,
  },
  data() {
    return {
      scrollBarHeight: 300,
    };
  },
  computed: {
    cartUrl() {
      return route("cart");
    },
    hasItems() {
      return this.items && !this.isEmpty(this.items) && this.items.length;
    },
  },
  methods: {
    toggleCartDrawer(mode) {
      if (mode === true) {
        this.$refs.cartDrawer.open();
      } else {
        this.$refs.cartDrawer.close();
      }
    },
    updateScrollBarHeight() {
      this.$nextTick(() => {
        let cartBody = this.$refs.cartDrawerBody;
        let cartBottom = this.$refs.cartDrawerBottom;

        if (cartBody && cartBottom) {
          let height = cartBody.clientHeight - cartBottom.clientHeight;
          this.scrollBarHeight = height;
          $(".ps").height(height);
        }
      })
    }
  },
  mounted() {
    this.$nextTick(async () => {
      await this.updateScrollBarHeight();

      if (this.$refs.cartDrawer) {
        this.$store.commit("defineDrawer", this.$refs.cartDrawer);
      }
    });
  },
  created() {
    const cartItems = localStorage.getItem("cartItems");

    if (cartItems) {
      this.$store.commit("setCart", JSON.parse(cartItems));
    } else {
      this.$store.commit("setCart", []);
    }
  },
};
</script>

<style>
</style>