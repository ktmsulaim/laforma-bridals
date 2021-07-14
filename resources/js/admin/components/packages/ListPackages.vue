<template>
  <div class="row" v-if="loading">
      <div class="col-md-4" v-for="(loadingItem, index) in 3" :key="index">
         <div class="card">
              <div class="card-img">
                  <vue-skeleton-loader
                        type="rect"
                        width="100%"
                        height="250px"
                        animation="wave"
                    />
              </div>
            <div class="card-body">
                <vue-skeleton-loader
                type="rect"
                width="100%"
                height="25px"
                rounded
                radius="8"
                animation="fade"
            />
            </div>
         </div>
      </div>
  </div>
  <div v-else-if="items && items.length" class="row">
      <div class="col-md-4" v-for="packages in items" :key="packages.id">
          <package :packages="packages"></package>
      </div>
      <div class="col-12 mt-2">
          <jw-pagination :items="packages.all" @changePage="displayItems"></jw-pagination>
      </div>
  </div>
  <div v-else class="row">
      <div class="col">
          <p>No packages found!</p>
      </div>
  </div>
</template>

<script>
import Package from './Package.vue'
export default {
    name: 'ListPackages',
    components:{
        Package,
    },
    data() {
        return {
            packages: {
                all: [],
                display: []
            },
            loading: true,
        }
    },
    computed: {
        items() {
            if(this.packages.all.length > 10) {
                return this.packages.display;
            } else {
                return this.packages.all;
            }
        }
    },
    methods: {
        fetchPackages() {
            axios.get(route('admin.packages.index'))
            .then(resp => this.packages.all = resp.data)
            .catch(err => toastr.error('Unable to load packages', 'Failed'))
            .finally(() => this.loading = false)
        },
        displayItems(items) {
            this.packages.display = items;
        }
    },
    created() {
        this.fetchPackages()
    }
}
</script>

<style>

</style>