<template>
  <div id="home-packages">
      <div class="row" v-if="loading">
          <div v-for="(item, index) in 4" :key="index" class="col-6 col-md-4 col-xl-3 mt-2">
            <vue-skeleton-loader
                type="rect"
                width="100%"
                height="200px"
                animation="wave"
                rounded
                :radius="8"
            />
        </div>
      </div>
      <div v-else-if="allPackages && Object.keys(allPackages).length">
          <carousel :items="4" :margin="15" :stagePadding="15" :responsive="responsive">
            <div v-for="packages in allPackages" :key="packages.id">
                <package :packages="packages"></package>
            </div>
          </carousel>
      </div>
    <no-data type="packages" :size="100" v-else></no-data>
  </div>
</template>

<script>
import carousel from 'vue-owl-carousel'

import NoData from '../NoData.vue'
import Package from '../packages/Package.vue'

export default {
    name: 'Packages',
    components: {
        NoData,
        Package,
        carousel,
    },
    data() {
        return {
            loading: false,
            allPackages: []
        }
    },
    computed: {
        responsive() {
            return {
                0: {
                    items: 1,
                    nav: false,
                    dots: false,
                },
                768: {
                    items: 2, 
                    nav: false,
                    dots: true,
                },
                992: {
                    items: 4
                }
            }
        }
    },
    methods: {
        fetchPackages() {
            this.loading = true;

            axios.get(route('packages.list'))
            .then(resp => this.allPackages = resp.data.data)
            .catch(err => this.$toast.open({
                message: 'Unable to load packages',
                type: 'error'
            }))
            .finally(() => {
                this.loading = false;
            })
        }
    },
    mounted() {
        this.fetchPackages()
    }
}
</script>

<style scoped>
    .owl-carousel .owl-stage {
        padding-bottom: 15px;
    }
</style>