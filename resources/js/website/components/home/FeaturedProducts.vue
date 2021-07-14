<template>
  <div v-if="loading" class="row small-gutters">
      <div v-for="(item, index) in 4" :key="index" class="col-6 col-md-4 col-xl-3 mt-2">
        <vue-skeleton-loader
            type="rect"
            width="100%"
            height="200px"
            animation="wave"
        />
      </div>
  </div>
  <div class="row small-gutters" v-else-if="products.length">
    <div v-for="product in products" :key="product.id" class="col-6 col-md-4 col-xl-3">
      <product :product="product"></product>
    </div>
  </div>
  <no-data type="products" size="100" v-else></no-data>
</template>

<script>
import Product from '../Product.vue'
export default {
  name: 'FeaturedProducts',
  data(){
    return {
      loading: false,
      products: []
    }
  },
  components:{
    Product
  },
  methods: {
    fetchProducts() {
      this.loading = true;

      axios.get(route('featuredProducts'))
      .then(resp => {
        this.products = resp.data.data
      })
      .catch(err => this.$toast.open({
        message: 'Unable to load featured products',
        type: 'error'
      }))
      .finally(() => this.loading = false)
    }
  },
  created() {
    this.fetchProducts();
  }
}
</script>

<style>

</style>