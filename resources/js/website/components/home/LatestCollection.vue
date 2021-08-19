<template>
  <div v-if="loading" class="row small-gutters">
      <div v-for="(item, index) in 4" :key="index" class="col-6 col-lg-3 col-md-4 mt-2">
        <vue-skeleton-loader
            type="rect"
            width="100%"
            height="200px"
            animation="wave"
        />
      </div>
  </div>
    <stack v-else-if="images" 
    :columnMinWidth="200" 
    monitor-images-loaded 
    class="image-stack" 
    :gutter-width="15"
    :gutter-height="15"
    >
        <stack-item v-for="(image, index) in images" :key="index" class="image">
            <a :href="getCollectionURL(image.gallery[0].slug)" :title="image.gallery[0].name">
                <div class="overlay">
                    <span class="gallery-name">{{ image.gallery[0].name }}</span>
                </div>
                <img :src="image.path" class="img-fluid" :alt="image.filename">
            </a>
        </stack-item>
    </stack>
    <no-data v-else :size="100" type="collections"></no-data>
</template>

<script>
import NoData from '../NoData.vue'
import { Stack, StackItem } from 'vue-stack-grid';
export default {
    name: "LatestCollection",
    components: { 
        NoData,
        Stack,
        StackItem
    },
    data() {
        return {
            loading: false,
            images: []
        }
    },
    methods: {
        fetchImages() {
            this.loading = true
            axios.get(route('collections.latest'))
            .then(resp => this.images = resp.data)
            .catch(err => this.$toast.open({
                message: 'Unable to load latest collection',
                type: 'error'
            }))
            .finally(() => this.loading = false)
        },
        getCollectionURL(slug) {
            if(slug) {
                return route('collections.show', {slug});
            }
        }
    },
    created() {
        this.fetchImages()
    }
}
</script>

<style>

</style>