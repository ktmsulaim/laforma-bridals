<template>
  <tr>
    <td>
      <div class="d-flex">
        <div class="thumb_cart">
          <img
            src="/img/470x290.png"
            :data-src="item.image"
            class="lazy"
            alt="Image"
          />
        </div>
        <div class="d-flex justify-content-center flex-column">
          <a :href="item.url">
            <span class="item_cart">{{ item.name }}</span>
          </a>
          <div class="mt-1 ml-2 product-options">
            <cart-item-options v-if="item.options && Object.keys(item.options).length" :data="item.options"></cart-item-options>
          </div>
        </div>
      </div>
    </td>
    <td>
      <div class="price_box">
            <span class="new_price">
                <span>{{ item.price }}</span>
            </span>
            <span v-if="item.special_price" class="old_price">{{ formatMoney(item.net_price) }}</span>
        </div>
    </td>
    <td>
      <div class="quantity">
        <button @click="decreaseQuantity">-</button>
        <input type="number" min="1" v-model="itemQuantity" @input="updateCart">
        <button @click="increaseQuantity">+</button>
      </div>
    </td>
    <td>
      <strong>{{ subTotal }}</strong>
    </td>
    <td class="options">
      <a @click="removeFromCart" href="javascript:void(0)"
        ><i class="ti-trash"></i
      ></a>
    </td>
  </tr>
</template>

<script>

import {mapGetters} from 'vuex'

export default {
  name: "CartItem",
  props: ["item", "qty"],
  data() {
    return {
      itemQuantity: 1,
    };
  },
  computed: {
    ...mapGetters({
      productQuantity: 'getProductMaxQuantity'
    }),
    subTotal() {
      if (this.itemQuantity > 0) {
        let price;
        if (this.item.special_price) {
          price = this.item.special_price * this.itemQuantity;
        } else {
          price = this.item.net_price * this.itemQuantity;
        }

        return this.formatMoney(price);
      } else {
        return 0;
      }
    },
  },
  methods: {
    increaseQuantity() {
      this.itemQuantity++;
      this.updateCart()
    },
    decreaseQuantity() {
      if(this.itemQuantity > 1) {
        this.itemQuantity--;
        this.updateCart()
      }
    },
    updateCart() {
      if(this.itemQuantity < 1) {
        this.itemQuantity = 1;
      }

      let updated = this.item;
      updated.quantity = this.itemQuantity;
      this.$store.commit("updateCart", updated);
    },
    removeFromCart() {
      this.$store.commit("removeFromCart", this.item);
    },
  },
  created() {
    if(this.item.quantity) {
      this.itemQuantity = this.item.quantity;
    }
  }
};
</script>

<style>
.thumb_cart, .item_cart {
  float: none;
}
</style>