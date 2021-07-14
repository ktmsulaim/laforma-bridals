<template>
  <div class="package">
      <div class="package-header">
          <span class="package-subtitle">{{ packages.name }}</span>
          <span class="package-title">{{ packages.price.formatted }}</span>
      </div>
      <div class="package-body">
          <ul class="features">
              <li v-for="feature in features" :key="feature.id">
                  <span>{{ feature.value }}</span>
                  <span v-if="feature.brand" class="brand">{{ feature.brand }}</span>
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