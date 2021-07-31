<template>
  <div class="package">
      <div class="package-header">
          <span class="package-subtitle">{{ packages.name }}</span>
          <span class="package-title">
              <span v-if="packages.special_price.has_special_price" class="price-box">
                  <span class="new-price">{{ packages.special_price.formatted }}</span>
                  <span class="old-price">{{ packages.price.formatted }}</span>
              </span>
              <span v-else class="new-price">{{ packages.price.formatted }}</span>
          </span>
      </div>
      <div class="package-body">
          <ul class="features">
              <li v-for="(feature, ind) in features" :key="ind">
                  <span>{{ feature.value }}</span>
                  <div class="brands-inline" v-if="feature.brand && feature.brand.length">
                    <span v-for="(brand, index) in feature.brand" :key="index" class="brand">
                        {{ brand }}
                    </span>
                  </div>
              </li>
          </ul>
      </div>
      <div class="package-footer">
          <a :href="packages.url" class="btn_1">Book now</a>
      </div>
  </div>
</template>

<script>
export default {
    name: 'Package',
    props: ['packages'],
    computed: {
        features() {
            if(this.packages.features) {
                let sorted = _.sortBy(this.packages.features, ['position'], ['asc'])
                return sorted;
            }
        },
    }
}
</script>

<style>

</style>