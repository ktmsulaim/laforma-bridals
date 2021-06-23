<template>
  <div>
      <div class="mb-2">
          <button @click="addFeature" class="btn btn-info btn-sm">
              <span class="mdi mdi-plus mr-2"></span>
              <span>Add new</span>
          </button>
      </div>
      <div v-if="features && features.length">
          <div v-for="(feature, index) in features" :key="feature.id" class="form-group">
              <label :for="`item-${feature.id}`">Feature {{ feature.id }}</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Type here..." aria-label="Feature" v-model="features[index].value" :id="`item-${feature.id}`" :aria-describedby="`feature-item-${feature.id}`">
                <div class="input-group-append" @click="removeFeature(index)">
                    <span class="input-group-text close-btn" :id="`feature-item-${feature.id}`">
                        <span class="mdi mdi-close-thick"></span>
                    </span>
                </div>
            </div>
          </div>
        </div>
        <div v-else>
            <p>No features were added.</p>
        </div>
  </div>
</template>

<script>
export default {
    name: 'Features',
    props: ['oldFeatures'],
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