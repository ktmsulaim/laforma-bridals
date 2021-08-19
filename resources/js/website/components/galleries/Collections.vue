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
    <stack v-else-if="collections" 
    :columnMinWidth="200" 
    monitor-images-loaded 
    class="image-stack" 
    :gutter-width="15"
    :gutter-height="15"
    >
        <stack-item v-for="(collection, index) in collections" :key="index" class="image">
            <a :href="getCollectionURL(collection.slug)" :title="collection.name">
                <img :src="collection.cover" class="img-fluid" alt="Cover">
                <div class="collection-name">
                    <span class="gallery-name">{{ collection.name }} ({{ collection.images.total }})</span>
                </div>
            </a>
        </stack-item>
    </stack>
    <no-data v-else :size="100" type="collections"></no-data>
</template>

<script>
import NoData from '../NoData.vue'
import { Stack, StackItem } from 'vue-stack-grid';
export default {
    name: "Collections",
    components: { 
        NoData,
        Stack,
        StackItem
    },
    data() {
        return {
            loading: false,
            collections: []
        }
    },
    methods: {
        fetchImages() {
            this.loading = true
            axios.get(route('collections.list'))
            .then(resp => this.collections = resp.data.data)
            .catch(err => this.$toast.open({
                message: 'Unable to load collections',
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