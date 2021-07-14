<template>
  <div class="card">
        <img class="card-img-top img-fluid" :src="packages.base_image" alt="Packages Image">
        <div class="card-body">
            <h4 class="card-title">{{ packages.name }}</h4>
            <div v-if="packages.features && packages.features.length" class="card-text">
                <p v-for="feature in packages.features" :key="feature.id">{{ feature.value }}</p>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ packages.price }}</h4>
                </div>
                <a :href="editUrl" class="btn btn-primary">
                    <span>Edit</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Package',
    props: ['packages'],
    computed: {
        editUrl() {
            if(this.packages) {
                return route('admin.packages.edit', this.packages.id)
            } else {
                return 'javascript:void(0)'
            }
        }
    }
}
</script>

<style>

</style>