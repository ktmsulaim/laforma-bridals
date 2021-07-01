<template>
  <tr>
    <td>
      <div class="thumb_cart">
        <img
          src="/img/470x290.png"
          :data-src="item.image"
          class="lazy"
          alt="Image"
        />
      </div>
      <a :href="item.url">
        <span class="item_cart">{{ item.name }}</span>
      </a>
    </td>
    <td>
      <strong>{{ item.price }}</strong>
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
export default {
  name: "CartItem",
  props: ["item", "qty"],
  data() {
    return {
      itemQuantity: 1,
      test: null,
    };
  },
  computed: {
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
      }
      this.updateCart()
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
</style>