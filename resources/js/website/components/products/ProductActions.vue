<template>
  <div>
    <ul>
      <li>
        <span
          class="tooltip-1"
          data-toggle="tooltip"
          data-placement="left"
          title="Add to favorites"
          ><i class="ti-heart"></i><span>Add to favorites</span></span
        >
      </li>
      <li v-if="available && product.options.has_options" @click="showOptions">
        <span
          data-toggle="tooltip"
          data-placement="left"
          class="tooltip-1"
          title="View options"
          ><i class="mdi mdi-eye-outline"></i><span>View options</span></span
        >
      </li>
      <li v-else-if="available" @click="addToCart(product)">
        <span
          class="tooltip-1"
          data-toggle="tooltip"
          data-placement="left"
          title="Add to cart"
          ><i class="ti-shopping-cart"></i><span>Add to cart</span></span
        >
      </li>
    </ul>

    <modal :name="`product-${product.id}-options`" :adaptive="true" height="auto" :scrollable="true">
      <div class="row h-100 options_modal">
        <div class="col-lg-6">
          <div class="options_modal_content">
            <h4>Options</h4>
            <product-options :product="product" @updatePrice="updatePrice" @updateOptions="updateOptions"></product-options>
            
          </div>
        </div>
        <div class="col-lg-6">
          <div class="mb-2">
            <b>{{ product.name }}</b>
          </div>
          <div class="price_box">
            <span v-if="product.special_price.has_special_price" class="old_price">{{ productOriginalPriceFormatted }}</span>
            <span class="new_price">
                <span v-if="product.special_price.has_special_price">{{ productPriceFormatted }}</span>
                <span v-else>{{ productOriginalPriceFormatted }}</span>
            </span>
        </div>
          <div class="my-2">
              <div class="quantity">
                <button @click="updateQuantity('decrease')">-</button>
                <input
                  type="number"
                  min="1"
                  v-model="quantity"
                  :max="product.qty"
                  @input="checkQuantity(product.qty)"
                />
                <button @click="updateQuantity('increase')">+</button>
              </div>
            </div>

            <div class="btn_add_to_cart">
              <button
                :disabled="!product.in_stock || addToCartLoading"
                @click="addToCart(product, quantity)"
                class="btn_1 text-uppercase w-100"
              >
                Add to Cart
              </button>
            </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import CartMixin from "../../mixins/CartMixin";
import ProductOptions from "./ProductOptions.vue";
export default {
  name: "ProductActions",
  props: ["product"],
  mixins: [CartMixin],
  components: {
    ProductOptions,
  },
  data() {
    return {
      productPrice: this.product.special_price.has_special_price ? this.product.special_price.original : 0,
      productPriceFormatted: this.product.special_price.has_special_price ? this.product.special_price.formatted : null,
      productOriginalPrice: this.product.price.original,
      productOriginalPriceFormatted: this.product.price.formatted,
      selectedOptions: null,
    }
  },
  computed: {
    available() {
      if (this.product.is_orderable === 0) {
        return false;
      }

      if (!this.product.in_stock) {
        return false;
      }

      return true;
    },
    price() {
      return this.product.special_price.has_special_price ? this.product.special_price.formatted : this.product.price.formatted;
    }
  },
  methods: {
    showOptions() {
      this.$modal.show(`product-${this.product.id}-options`);
    },
    updatePrice(value) {
      this.productPrice = value.special_price;
      this.productPriceFormatted = this.formatMoney(value.special_price)
      this.productOriginalPrice = value.price;
      this.productOriginalPriceFormatted = this.formatMoney(value.price);
    },
    updateOptions(options) {
      this.selectedOptions = options;
    }
  }
};
</script>

<style scoped>
.price {
  font-weight: bold;
  color: #ff5353;
  font-size: 1.3125rem;
}

</style>