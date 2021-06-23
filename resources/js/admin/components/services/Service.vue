<template>
  <div class="card">
        <img class="card-img-top img-fluid" :src="service.base_image" alt="Service Image">
        <div class="card-body">
            <h4 class="card-title">{{ service.name }}</h4>
            <div v-if="service.features && service.features.length" class="card-text">
                <p v-for="feature in service.features" :key="feature.id">{{ feature.value }}</p>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ service.price }}</h4>
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
    name: 'Service',
    props: ['service'],
    computed: {
        editUrl() {
            if(this.service) {
                return route('admin.services.edit', this.service.id)
            } else {
                return 'javascript:void(0)'
            }
        }
    }
}
</script>

<style>

</style>