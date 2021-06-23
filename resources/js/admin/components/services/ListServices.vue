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
      <div class="col-md-4" v-for="service in items" :key="service.id">
          <service :service="service"></service>
      </div>
      <div class="col-12 mt-2">
          <jw-pagination :items="services.all" @changePage="displayItems"></jw-pagination>
      </div>
  </div>
  <div v-else class="row">
      <div class="col">
          <p>No services found!</p>
      </div>
  </div>
</template>

<script>
import Service from './Service.vue'
export default {
    name: 'ListServices',
    components:{
        Service,
    },
    data() {
        return {
            services: {
                all: [],
                display: []
            },
            loading: true,
        }
    },
    computed: {
        items() {
            if(this.services.all.length > 10) {
                return this.services.display;
            } else {
                return this.services.all;
            }
        }
    },
    methods: {
        fetchServices() {
            axios.get(route('admin.services.index'))
            .then(resp => this.services.all = resp.data)
            .catch(err => toastr.error('Unable to load services', 'Failed'))
            .finally(() => this.loading = false)
        },
        displayItems(items) {
            this.services.display = items;
        }
    },
    created() {
        this.fetchServices()
    }
}
</script>

<style>

</style>