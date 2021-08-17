<template>
  <li class="product-action add-to-favourites">
      <div v-if="loading">
          <span><i class="mdi mdi-spin mdi-loading"></i></span>
      </div>
      <div v-else>
        <span @click="removeFromWishlist" v-if="newStatus"><i class="mdi mdi-heart"></i><span>Remove from favorites</span></span>
        <span @click="addToWishlist" v-else><i class="mdi mdi-heart-outline"></i><span>Add to favorites</span></span>
      </div>
  </li>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "FavoriteControl",
  props: ["isFavorite", "productId"],
  data() {
    return {
      loading: false,
      newStatus: this.isFavorite,
      data: {
        product_id: this.productId,
        customer_id: null,
      },
    };
  },
  computed: {
    ...mapGetters({
      authenticated: "authenticated",
      authenticatedUser: "authenticatedUser",
    }),
  },
  methods: {
    addToWishlist() {
      this.checkAuth();
      this.loading = true;
      axios.post(route('customer.wishlist.store'), this.data)
      .then(resp => {
          this.newStatus = true
      })
      .catch(err => {
          this.$toast.open({
              message: 'Unable to add the product to the wishlist',
              type: 'error'
          })
      })
      .finally(() => this.loading = false)
    },
    removeFromWishlist() {
      this.checkAuth();
      this.loading = true;
      axios.post(route('customer.wishlist.destroy'), this.data)
      .then(resp => {
          this.newStatus = false;
      })
      .catch(err => {
          this.$toast.open({
              message: 'Unable to remove the product from the wishlist',
              type: 'error'
          })
      })
      .finally(() => this.loading = false)
    },
    checkAuth() {
      if (!this.authenticated) {
        this.$toast.open({
          message: "Sign in to add an item to the wishlist",
          type: "error",
        });
        return;
      }
    },
  },
  watch: {
    authenticatedUser(customer) {
      if (customer && !this.isEmpty(customer)) {
        this.data.customer_id = customer.id;
      }
    },
  },
  created() {
    if (this.authenticated) {
      this.data.customer_id = this.authenticatedUser.id;
    }
  },
};
</script>

<style>
</style>