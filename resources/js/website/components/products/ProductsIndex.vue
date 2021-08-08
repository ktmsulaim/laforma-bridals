<template>
  <div class="row">
    <aside class="col-lg-3" id="sidebar_fixed">
      <products-filter-side :maxPrice="maxPrice" @updateFilter="fetchProducts"></products-filter-side>
    </aside>
    <!-- /col -->
    <div class="col-lg-9">
      <loading v-if="loading"></loading>
      <div class="row small-gutters" v-else-if="hasProducts">
        <div
          class="col-6 col-lg-4 col-md-4"
          v-for="product in productsData.data"
          :key="product.id"
        >
          <product :product="product"></product>
        </div>
      </div>
      <div v-else>
        <NoData />
      </div>
      <div class="pagination__wrapper" v-if="hasProducts && productsData.meta.last_page > 1 && !loading">
        <pagination :data="productsData" @pagination-change-page="fetchProducts" align="center"></pagination>
      </div>
    </div>
    <!-- /col -->
  </div>
  <!-- /row -->
</template>

<script>
import Loading from "../Loading.vue";
import Product from "../Product.vue";
import NoData from "../NoData.vue";

import {mapGetters} from 'vuex'

import ProductsFilterSide from './ProductsFilterSide.vue'

export default {
  name: "ProductsIndex",
  props: ["categories", "tags", "search", "maxPrice"],
  components: {
    Loading,
    Product,
    NoData,
    ProductsFilterSide,
  },
  data() {
    return {
      productsData: [],
    };
  },
  computed:{
    ...mapGetters({
      'loading': 'getLoading',
      'filters': 'getFilters',
    }),
    hasProducts() {
      return this.productsData && this.productsData.data && this.productsData.data.length;
    },
    hasFilter() {
      return this.filters && (!_.isEmpty(this.filters.categories) || !_.isEmpty(this.filters.tags))
    }
  },
  methods: {
    setLoading(status) {
      this.$store.commit('setLoading', status)
    },
    fetchProducts(page = 1) {
      let params = {
          page
      };
      
      this.setLoading(true);

      if(this.hasFilter) {
        if(this.filters.categories) {
          params.categories = this.filters.categories;
        }

        if(this.filters.tags) {
          params.tags = this.filters.tags;
        }

        if(this.filters.price) {
          params.price = this.filters.price;
        }
      }

      if(this.search) {
        params.search = JSON.stringify(this.search);
      }

      axios
        .get(route('products.get'), {
          params
        })
        .then((resp) => (this.productsData = resp.data))
        .catch((err) =>
          this.$toastr.open({
            message: "Failed to load products",
            type: "error",
          })
        )
        .finally(() => (this.setLoading(false)));
    },
  },
  mounted() {
    this.fetchProducts();

    this.$nextTick(() => {
      // Sticky sidebar
      $("#sidebar_fixed").theiaStickySidebar({
        minWidth: 991,
        updateSidebarHeight: false,
        additionalMarginTop: 90,
      });

      // Prevent close dropdown filters
      $(".filters_listing_1 .dropdown-menu .filter_type ul").on(
        "click",
        function (e) {
          e.stopPropagation();
        }
      );

      //Filters version 2 mobile
      $("a.open_filters").on("click", function () {
        $(".filter_col").toggleClass("show");
        $("main").toggleClass("freeze");
        $(".layer").toggleClass("layer-is-visible");
      });

      //Filters collapse
      var $headingFilters = $(".filter_type h4 a");
      $headingFilters.on("click", function () {
        $(this).toggleClass("opened");
      });
      $headingFilters.on("click", function () {
        $(this).toggleClass("closed");
      });
    });
  },
  created() {
    if(this.categories) {
      this.$store.commit('setCategories', this.categories)
    }

    if(this.tags) {
      this.$store.commit('setTags', this.tags)
    }
  }
};
</script>

<style>
</style>