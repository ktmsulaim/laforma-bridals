<template>
  <div>
    <loading v-if="loading"></loading>
    <div class="row" v-else-if="galleries && !isEmpty(galleries)">
        <div v-for="(gallery, index) in galleries" :key="index" class="col-lg-3 col-md-4">
            <div class="gallery-item">
                <div class="gallery-item-thumbnail">
                    <div class="overlay">
                        <p>{{ gallery.description }}</p>
                        <div class="status">
                            <span class="badge badge-pill badge-success" v-if="gallery.status === 1">Published</span>
                            <span class="badge badge-pill badge-warning" v-else>Draft</span>
                        </div>
                    </div>
                    <img :src="gallery.cover" class="img-fluid" alt="Thumbnail">
                </div>
                <div class="gallery-item-title">
                    <a :href="getGalleryURL(gallery.id)">{{ gallery.name }} ({{ gallery.images.total }})</a>
                </div>
            </div>
        </div>
        <div class="col-12 mt-2">
        <pagination
            :data="galleriesData"
            @pagination-change-page="fetchGalleries"
            align="center"
            ></pagination>
        </div>
    </div>
    <div v-else>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <p>No galleries found!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import Loading from '../Loading.vue'
export default {
    name: "ListGalleries",
    components: {
        Loading,
    },
    data() {
        return {
            loading: false,
            galleriesData: []
        }
    },
    computed: {
        galleries() {
            if(this.galleriesData) {
                return this.galleriesData.data;
            }
        }
    },
    methods: {
        isEmpty(obj) {
            if(obj) {
                return _.isEmpty(obj)
            }
        },
        getGalleryURL(id) {
            if(id) {
                return route('admin.galleries.edit', id)
            }
        },
        fetchGalleries(page = 1) {
            this.loading = true;
            axios.get(route('admin.galleries.list', {page}))
            .then(resp => {
                this.galleriesData = resp.data
            })
            .catch(err => {
                toastr.error('Unable to fetch galleries', 'Error')
            })
            .finally(() => this.loading = false)
        }
    },
    mounted() {
        this.fetchGalleries()
    }
}
</script>

<style>

</style>