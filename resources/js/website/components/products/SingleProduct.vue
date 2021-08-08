<template>
  <loading v-if="loading"></loading>
  <div v-else>
    <div class="container margin_30">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <image-slider :images="product.images"></image-slider>
        </div>
        <div class="col-lg-6">
          <div class="mb-2" v-html="product.description"></div>
          <div class="prod_options version_2" v-if="product.is_orderable">
                        <product-options
                          :product="product"
                          @updatePrice="updatePrice"
                          @updateOptions="updateOptions"
                        ></product-options>

                        <div class="row mt-3">
                          <div class="col">
                            <div class="price_main">
                              <span v-if="product.special_price.has_special_price" class="old_price">{{ productOriginalPriceFormatted }}</span>
                              <span class="new_price">
                                  <span v-if="product.special_price.has_special_price">{{ productPriceFormatted }}</span>
                                  <span v-else>{{ productOriginalPriceFormatted }}</span>
                              </span>
                              <span
                                v-if="product.special_price.has_special_price"
                                class="percentage"
                                >-{{ product.special_price.percentage }}%</span>
                            
                            </div>
                          </div>
                        </div>
                        
                        <div class="row mt-3">
                          <div class="col-lg-6 col-md-6">
                            <div class="numbers-row">
                              <input
                                type="text"
                                v-model="quantity"
                                id="quantity_1"
                                class="qty2"
                                name="quantity_1"
                                :max="product.qty"
                                @input="checkQuantity(productQuantity)"
                              />
                              <div
                                @click="updateQuantity('increase')"
                                class="inc button_inc"
                              >
                                +
                              </div>
                              <div
                                @click="updateQuantity('decrease')"
                                class="dec button_inc"
                              >
                                -
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="btn_add_to_cart">
                              <button
                                :disabled="!product.in_stock"
                                @click="addToCart(product, quantity)"
                                class="btn_1 text-uppercase w-100"
                              >
                                Add to Cart
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
        </div>
      </div>
    </div>
    <div class="bg_white pt-5">
      <div class="tabs_product version_2">
        <div class="container">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a
                id="tab-A"
                href="#pane-A"
                class="nav-link active"
                data-toggle="tab"
                role="tab"
                >Specifications</a
              >
            </li>
            <li class="nav-item">
              <a
                id="tab-B"
                href="#pane-B"
                class="nav-link"
                data-toggle="tab"
                role="tab"
                >Reviews</a
              >
            </li>
          </ul>
        </div>
      </div>
      <!-- /tabs_product -->

      <div class="tab_content_wrapper">
        <div class="container">
          <div class="tab-content" role="tablist">
            <div
              id="pane-A"
              class="card tab-pane fade active show"
              role="tabpanel"
              aria-labelledby="tab-A"
            >
              <div class="card-header" role="tab" id="heading-A">
                <h5 class="mb-0">
                  <a
                    class="collapsed"
                    data-toggle="collapse"
                    href="#collapse-A"
                    aria-expanded="false"
                    aria-controls="collapse-A"
                  >
                    Specifications
                  </a>
                </h5>
              </div>

              <div
                id="collapse-A"
                class="collapse"
                role="tabpanel"
                aria-labelledby="heading-A"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6 mx-auto">
                      <div class="table-responsive">
                        <table class="table table-sm table-striped">
                          <tbody>
                            <tr>
                              <td width="150"><strong>SKU</strong></td>
                              <td>{{ product.sku }}</td>
                            </tr>
                            <tr>
                              <td><strong>Stock availability</strong></td>
                              <td>
                                <span v-if="product.in_stock">Available</span>
                                <span v-else>Out of stock</span>
                              </td>
                            </tr>
                            <tr>
                              <td><strong>Category</strong></td>
                              <td>
                                <a :href="product.category.url">{{
                                  product.category.name
                                }}</a>
                              </td>
                            </tr>
                            <tr v-if="product.tags && product.tags.length">
                              <td><strong>Tags</strong></td>
                              <td>
                                <a
                                  :href="getTagLink(tag.slug)"
                                  class="label label-secondary"
                                  v-for="(tag, index) in product.tags"
                                  :key="index"
                                  >{{ tag.name }}</a
                                >
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!-- /table-responsive -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /TAB A -->
            <div
              id="pane-B"
              class="card tab-pane fade"
              role="tabpanel"
              aria-labelledby="tab-B"
            >
              <div class="card-header" role="tab" id="heading-B">
                <h5 class="mb-0">
                  <a
                    class="collapsed"
                    data-toggle="collapse"
                    href="#collapse-B"
                    aria-expanded="false"
                    aria-controls="collapse-B"
                  >
                    Reviews
                  </a>
                </h5>
              </div>
              <div
                id="collapse-B"
                class="collapse"
                role="tabpanel"
                aria-labelledby="heading-B"
              >
                <div class="card-body">
                  <div class="row justify-content-between">
                    <div class="col-lg-5">
                      <div class="review_content">
                        <div class="clearfix add_bottom_10">
                          <span class="rating"
                            ><i class="icon-star"></i><i class="icon-star"></i
                            ><i class="icon-star"></i><i class="icon-star"></i
                            ><i class="icon-star"></i><em>5.0/5.0</em></span
                          >
                          <em>Published 54 minutes ago</em>
                        </div>
                        <h4>"Commpletely satisfied"</h4>
                        <p>
                          Eos tollit ancillae ea, lorem consulatu qui ne, eu
                          eros eirmod scaevola sea. Et nec tantas accusamus
                          salutatus, sit commodo veritus te, erat legere fabulas
                          has ut. Rebum laudem cum ea, ius essent fuisset ut.
                          Viderer petentium cu his.
                        </p>
                      </div>
                    </div>
                    <div class="col-lg-5">
                      <div class="review_content">
                        <div class="clearfix add_bottom_10">
                          <span class="rating"
                            ><i class="icon-star"></i><i class="icon-star"></i
                            ><i class="icon-star"></i
                            ><i class="icon-star empty"></i
                            ><i class="icon-star empty"></i
                            ><em>4.0/5.0</em></span
                          >
                          <em>Published 1 day ago</em>
                        </div>
                        <h4>"Always the best"</h4>
                        <p>
                          Et nec tantas accusamus salutatus, sit commodo veritus
                          te, erat legere fabulas has ut. Rebum laudem cum ea,
                          ius essent fuisset ut. Viderer petentium cu his.
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- /row -->
                  <div class="row justify-content-between">
                    <div class="col-lg-5">
                      <div class="review_content">
                        <div class="clearfix add_bottom_10">
                          <span class="rating"
                            ><i class="icon-star"></i><i class="icon-star"></i
                            ><i class="icon-star"></i><i class="icon-star"></i
                            ><i class="icon-star empty"></i
                            ><em>4.5/5.0</em></span
                          >
                          <em>Published 3 days ago</em>
                        </div>
                        <h4>"Outstanding"</h4>
                        <p>
                          Eos tollit ancillae ea, lorem consulatu qui ne, eu
                          eros eirmod scaevola sea. Et nec tantas accusamus
                          salutatus, sit commodo veritus te, erat legere fabulas
                          has ut. Rebum laudem cum ea, ius essent fuisset ut.
                          Viderer petentium cu his.
                        </p>
                      </div>
                    </div>
                    <div class="col-lg-5">
                      <div class="review_content">
                        <div class="clearfix add_bottom_10">
                          <span class="rating"
                            ><i class="icon-star"></i><i class="icon-star"></i
                            ><i class="icon-star"></i><i class="icon-star"></i
                            ><i class="icon-star"></i><em>5.0/5.0</em></span
                          >
                          <em>Published 4 days ago</em>
                        </div>
                        <h4>"Excellent"</h4>
                        <p>
                          Sit commodo veritus te, erat legere fabulas has ut.
                          Rebum laudem cum ea, ius essent fuisset ut. Viderer
                          petentium cu his.
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- /row -->
                  <p class="text-right">
                    <a href="leave-review.html" class="btn_1">Leave a review</a>
                  </p>
                </div>
                <!-- /card-body -->
              </div>
            </div>
            <!-- /tab B -->
          </div>
          <!-- /tab-content -->
        </div>
        <!-- /container -->
      </div>
      <!-- /tab_content_wrapper -->
    </div>
  </div>
</template>

<script>
import Loading from "../Loading.vue";
import ImageSlider from "./ImageSlider.vue";
import CartMixin from "../../mixins/CartMixin";
import ProductOptions from './ProductOptions.vue'
export default {
  name: "SingleProduct",
  props: ["productId"],
  mixins: [CartMixin],
  components: {
    Loading,
    ImageSlider,
    ProductOptions
  },
  data() {
    return {
      loading: true,
      product: null,
      productPrice: 0,
      productPriceFormatted: null,
      productOriginalPrice: 0,
      productOriginalPriceFormatted: null,
      selectedOptions: null,
    };
  },
  methods: {
    getProduct() {
      if (this.productId) {
        axios
          .get(route("products.show", this.productId))
          .then((resp) => {
            this.product = resp.data.data;
            this.productPrice = this.product.special_price.has_special_price ? this.product.special_price.original : 0;
            this.productPriceFormatted =this.product.special_price.has_special_price ? this.product.special_price.formatted : null;
            this.productOriginalPrice = this.product.price.original;
            this.productOriginalPriceFormatted = this.product.price.formatted;
          })
          .catch((err) =>
            this.$toast.open({
              message: "Unable to load the product",
              type: "error",
            })
          )
          .finally(() => (this.loading = false));
      }
    },
    updatePrice(value) {
      this.productPrice = value.special_price;
      this.productPriceFormatted = this.formatMoney(value.special_price);
      this.productOriginalPrice = value.price;
      this.productOriginalPriceFormatted = this.formatMoney(value.price);
    },
    updateOptions(options) {
      this.selectedOptions = options;
    },
    getTagLink(slug) {
      if(slug) {
        return route('products.index', {tag: slug})
      }
    }
  },
  created() {
    this.getProduct();
  },
};
</script>

<style>
</style>