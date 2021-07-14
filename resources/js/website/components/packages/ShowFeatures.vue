<template>
  <div>
      <span @click="openFeaturesModal" class="show-features-trigger">
        <span class="mdi mdi-star-circle-outline mr-1"></span>  Show features
        </span>
      <modal name="packageFeatures" :adaptive="true" height="auto" :scrollable="true" transition="fade" width="300px">
          <div class="p-4">
              <h4 class="modal-title">Features</h4>
              <ul class="list" v-if="hasFeatures">
                  <li class="list-item" v-for="feature in sortedFeatures" :key="feature.id">
                      <span class="value">{{ feature.value }}</span>
                      <span class="brand" v-if="feature.brand">{{ feature.brand }}</span>
                  </li>
              </ul>
          </div>
      </modal>
  </div>
</template>

<script>
export default {
    name: "ShowFeatures",
    props: ['features'],
    computed:{
        hasFeatures() {
            return this.features && this.features.length;
        },
        sortedFeatures() {
            return _.sortBy(this.features, ['position'], ['asc'])
        }
    },
    methods: {
        openFeaturesModal() {
            this.$modal.show('packageFeatures')
        }
    }
}
</script>

<style scoped>
    .show-features-trigger {
        text-transform: uppercase;
        color: #444;
        cursor: pointer;
        margin-bottom: 20px;
        display: block;
    }

    .modal-title {
        text-transform: uppercase;
        text-align: center;
        font-size: 20px;
    }

    .list{
        list-style: none;
        padding: 0;
    }
    .list li {
        padding: 12px;
        text-align: center;
        color: #666;
        font-size: 16px;
        border-bottom: 1px solid #e1e1e1;

    }
    .list li:last-child {
        border-bottom: none;
    }
</style>