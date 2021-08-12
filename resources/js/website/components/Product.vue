<template>
  <div class="grid_item">
        <figure>
            <span class="ribbon off" v-if="product.special_price.has_special_price">-{{ product.special_price.percentage }}%</span>
            <span class="ribbon new" v-else-if="product.is_new">New</span>
            <a :href="product.url" class="product-image">
                <img class="img-fluid lazy" :src="product.base_image" :data-src="product.base_image" :alt="product.name">
            </a>
            <div v-if="!product.in_stock">
                <div class="out-of-stock">Out of stock</div>
            </div>
            <div v-else>
                <div v-if="product.special_price.has_special_price && product.special_price.expires" :data-countdown="product.special_price.expires" class="countdown"></div>
            </div>
        </figure>
        <div class="rating">
            <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
        </div>
        <a :href="product.url">
            <h3>{{ product.name }}</h3>
        </a>
        <div class="price_box">
            <span v-if="product.special_price.has_special_price" class="old_price">{{ product.price.formatted }}</span>
            <span class="new_price">
                <span v-if="product.special_price.has_special_price">{{ product.special_price.formatted }}</span>
                <span v-else>{{ product.price.formatted }}</span>
            </span>
        </div>
        <product-actions :product="product"></product-actions>
    </div>
</template>

<script>
import ProductActions from './products/ProductActions.vue'
export default {
    name: 'Product',
    props: ['product'],
    components: {
        ProductActions
    },
    mounted() {
        this.$nextTick(() => {
            $('[data-countdown]').each(function() {
                var $this = $(this), expiryDate = $(this).data('countdown'), finalDate = moment(expiryDate, 'YYYY/MM/DD');
                
                finalDate.set({
                    "hour": 23,
                    "minute": 59,
                    "second": 59
                })

                $this.countdown(finalDate.format('YYYY/MM/DD HH:mm:ss'), function(event) {
                    $this.html(event.strftime('%DD %H:%M:%S'));
                });
            });

            $('[data-toggle="tooltip"]').tooltip()
        })
    },
    created() {
        if(!this.product.options.has_options) {
            // this.$store.commit('setProductMaxQuantity', this.product.qty)
        }
    }
}
</script>

<style scoped>
    .product-image {
        display: flex;
        height: 290px;
        overflow: hidden;
    }

    .product-image img {
        object-fit: cover;
    }
</style>