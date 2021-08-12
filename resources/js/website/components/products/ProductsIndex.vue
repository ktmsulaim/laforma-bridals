<template>
  <div class="row">
    <aside class="col-lg-3" id="sidebar_fixed">
      <products-filter-side
        :maxPrice="maxPrice"
        @updateFilter="fetchProducts"
      ></products-filter-side>
    </aside>
    <!-- /col -->
    <div class="col-lg-9">
      <loading v-if="loading"></loading>
      <div class="row small-gutters" v-else-if="hasProducts">
        <div
          :class="{'col-6 col-lg-4 col-md-4': mode === 'grid', 'col-12': mode === 'list'}"
          v-for="product in productsData.data"
          :key="product.id"
        >
          <product v-if="mode === 'grid'" :product="product"></product>
          <product-vertical v-else-if="mode === 'list'" :product="product"></product-vertical>
        </div>
      </div>
      <div v-else>
        <NoData />
      </div>
      <div
        class="pagination__wrapper"
        v-if="hasProducts && productsData.meta.last_page > 1 && !loading"
      >
        <pagination
          :data="productsData"
          @pagination-change-page="fetchProducts"
          align="center"
        ></pagination>
      </div>
    </div>
    <!-- /col -->
  </div>
  <!-- /row -->
</template>

<script>
import Loading from "../Loading.vue";
import Product from "../Product.vue";
import ProductVertical from "../ProductVertical.vue";
import NoData from "../NoData.vue";

import { mapGetters } from "vuex";

import ProductsFilterSide from "./ProductsFilterSide.vue";

export default {
  name: "ProductsIndex",
  props: ["categories", "tags", "query", "maxPrice"],
  components: {
    Loading,
    Product,
    ProductVertical,
    NoData,
    ProductsFilterSide,
  },
  data() {
    return {
      productsData: [],
    };
  },
  computed: {
    ...mapGetters({
      loading: "getLoading",
      filters: "getFilters",
      mode: 'getMode',
      sort: 'getSort'
    }),
    hasProducts() {
      return (
        this.productsData &&
        this.productsData.data &&
        this.productsData.data.length
      );
    },
    hasFilter() {
      return (
        this.filters &&
        (!_.isEmpty(this.filters.categories) || !_.isEmpty(this.filters.tags ) ||
        !_.isEmpty(this.filters.price) || !_.isEmpty(this.filters.attributes)
        )
      );
    },
  },
  methods: {
    setLoading(status) {
      this.$store.commit("setLoading", status);
    },
    fetchProducts(page = 1) {
      let params = {
        page,
      };

      this.setLoading(true);

      if (this.hasFilter) {
        if (this.filters.categories) {
          params.categories = this.filters.categories;
        }

        if (this.filters.tags) {
          params.tags = this.filters.tags;
        }

        if (this.filters.price) {
          params.price = this.filters.price;
        }

        if(this.filters.attributes) {
          params.attributes = this.filters.attributes
        }
      }

      if(this.sort) {
        params.sort = this.sort;
      }

      if (this.query) {
        if (this.query.search) {
          params.search = JSON.stringify(this.query.search);
        }

        if (this.query.tag) {
          params.tag = JSON.stringify(this.query.tag);
        }
      }

      axios
        .get(route("products.get"), {
          params,
        })
        .then((resp) => (this.productsData = resp.data))
        .catch((err) =>
          this.$toastr.open({
            message: "Failed to load products",
            type: "error",
          })
        )
        .finally(() => this.setLoading(false));
    },
  },
  watch:{
    sort(newVal) {
      if(newVal) {
        this.fetchProducts()
      }
    }
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
    if (this.categories) {
      this.$store.commit("setCategories", this.categories);
    }

    if (this.tags) {
      this.$store.commit("setTags", this.tags);
    }

    if (this.query) {
      let category,tag;
      let categorySlug = this.query.category;
      let tagSlug = this.query.tag;

      if (this.categories) {
        category = this.categories.find((cat) => cat.slug === categorySlug);
      }

      if(this.tags) {
        tag = this.tags.find(singleTag => singleTag.slug === tagSlug)
      }

      if(category || tag) {
        this.$store.commit("applyFilter", {
          categories: category ? JSON.stringify([category.id]) : [],
          tags: tag ? JSON.stringify([tag.id]) : [],
          price: null,
        });
      }

    }
  },
};
</script>

<style>
</style>