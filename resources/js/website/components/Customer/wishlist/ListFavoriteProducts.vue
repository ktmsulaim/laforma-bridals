<template>
  <div ref="listWishlist"></div>
</template>

<script>
import {mapGetters} from 'vuex'
import { Grid, html, h } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
    name: 'ListFavoriteProducts',
    data() {
      return {
        grid: null,
      }
    },
    computed: {
      ...mapGetters({
          authenticated: 'authenticated',
          authenticatedUser: 'authenticatedUser'
      }),
    },
    methods: {
      destroy(id) {
        if(id) {
          this.$swal({
              titleText: 'Are you sure?',
              icon: 'warning',
              allowOutsideClick: false,
              showCancelButton: true,
              confirmButtonText: 'Proceed',
              confirmButtonColor: '#ff5b5b',
          })
          .then(response => {
              if(response.isConfirmed) {
                  axios.post(route('customer.wishlist.destroy', {product_id: id, customer_id: this.authenticated ? this.authenticatedUser.id : null}))
                  .then(resp => {
                      this.$toast.open({
                          message: 'The product has been removed from your wishlist.',
                          type: 'success'
                      })
                      this.grid.forceRender()
                  })
                  .catch(err => {
                      this.$swal('Unable to remove the product from your wishlist', '', 'error')
                  })
              }
          })
          .catch(err => {
              this.$swal('Sorry! Unable to remove the product from your wishlist. Try again later', '', 'error')
          })
        }
      }
    },
    mounted() {
      this.grid = new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Product",
        },
        {
          name: "Price",
        },
        {
          name: "In stock",
          formatter: (_, row) => {
            const stock = row.cells[3].data
            if(typeof stock === 'string') {
              return html(`<span class="badge badge-danger badge-pill">${stock}</span>`)
            } else if(typeof stock === 'number' || typeof parseInt(stock) === 'number') {
              return html(`<span class="badge badge-${stock ? 'success' : 'danger'} badge-pill">${stock ? 'In stock' : 'Out of stock'}</span>`)
            }
          }
        },
        {
          name: "Actions",
          formatter: (_, row) =>
            h('button', {
              className: 'btn btn-danger',
              onClick: () => this.destroy(row.cells[4].data)
            }, 'Delete'),
        },
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("customer.wishlist.list"),
        then: (data) =>
          data.data.map((item, index) => [
            index + 1,
            h('div', {}, [
              h('img', {src: item.base_image, width: 60}),
              h('a', { href: item.url, title: item.name, style: {marginTop: 10, display: 'block'}}, this.str_limit(item.name, 20))
            ]),
            item.special_price.has_special_price ? item.special_price.formatted : item.price.formatted,
            item.is_orderable ? item.in_stock : 'Not orderable',
            item.id,
          ]),
        total: (data) => data.count,
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to load wishlist.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        summary: true,
      },
    }).render(this.$refs.listWishlist);
    }
}
</script>

<style>

</style>