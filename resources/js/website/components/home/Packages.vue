<template>
  <div>
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
      <div class="row" v-else-if="allPackages && Object.keys(allPackages).length">
          <div v-for="packages in allPackages" :key="packages.id" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <package :packages="packages"></package>
          </div>
      </div>
    <no-data type="packages" :size="100" v-else></no-data>
  </div>
</template>

<script>
import NoData from '../NoData.vue'
import Package from '../packages/Package.vue'
export default {
    name: 'Packages',
    components: {
        NoData,
        Package,
    },
    data() {
        return {
            loading: false,
            allPackages: []
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

<style>

</style>