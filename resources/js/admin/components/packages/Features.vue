<template>
  <div>
      <div class="mb-2">
          <button @click="addFeature" class="btn btn-info btn-sm">
              <span class="mdi mdi-plus mr-2"></span>
              <span>Add new</span>
          </button>
      </div>
      <div v-if="features && features.length">
          <draggable v-model="features" @end="sortList" handle=".card-header">
            <div v-for="(feature, index) in features" :key="feature.id" class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0">{{ feature.value ? feature.value : `Untitled-${index + 1}` }}</h4>
                    <span @click="removeFeature(index)" class="mdi mdi-close"></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label :for="`value-${index}`">Feature</label>
                            <input type="text" class="form-control" v-model="features[index].value" :id="`value-${index}`">
                        </div>
                        <div class="col-md-6">
                            <label :for="`brand-${index}`">Brand</label>
                            <input type="text" class="form-control" v-model="features[index].brand" :id="`brand-${index}`">
                        </div>
                    </div>
                </div>
            </div>
          </draggable>
        </div>
        <div v-else>
            <p>No features were added.</p>
        </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    name: 'Features',
    props: ['oldFeatures'],
    components: {
        draggable,
    },
    data() {
        return {
            features: [],
        }
    },
    methods: {
        addFeature() {
            this.features.push({
                id: this.id,
                value: null,
                brand: null,
                position: this.id,
            })
        },
        removeFeature(index) {
            if(this.features[index]) {
                this.features.splice(index, 1);
                this.resetIds()
            }
        },
        resetIds() {
            if(this.features.length) {
                this.features.forEach((item, index) => item.id = index + 1)
            }
        },
        updateFeatures(value) {
            this.$emit('saved', value)
        },
        sortList() {
            this.features.forEach((feature, index) => feature.position = index + 1)
        }
    },
    computed: {
        id() {
            if(this.features && this.features.length > 0) {
                return this.features.length + 1;
            } else {
                return 1;
            }
        }
    },
    watch: {
        features: {
            handler(oldVal, newVal) {
                if(oldVal) {
                    this.updateFeatures(oldVal)
                } else if(newVal) {
                    this.updateFeatures(newVal)
                }
            },
            deep: true,
        }
    },
    created(){
        if(this.oldFeatures) {
            this.features = this.oldFeatures

            this.updateFeatures(this.oldFeatures)
        }
    }
}
</script>

<style>
.close-btn:hover {
    cursor: pointer;
    color: red;
}
</style>