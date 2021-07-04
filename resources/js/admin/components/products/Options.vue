<template>
  <div>
      <button @click="addNewOption" class="btn btn-info mb-2">
          <span class="mdi mdi-plus mr-2"></span>
          Add option
      </button>
      <div class="mb-2" v-if="options && options.length" id="accordion">
          <draggable v-model="options" @end="sortList" handle=".card-header">
              <div class="card border" v-for="(option, index) in options" :key="index">
                  <div class="card-header d-flex justify-content-between" data-toggle="collapse" :href="`#card-${index}`" :aria-expanded="index == 0">
                      <span>
                            <b v-if="option.name">{{ option.name }}</b>
                            <b v-else>Option {{ index + 1 }}</b>
                      </span>
                      <span @click="removeOption(index)" class="mdi mdi-close remove"></span>
                  </div>
                  <div :id="`card-${index}`" class="collapse" :class="{'show': index == 0}" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label :for="`name-${index}`">Name</label>
                                    <input type="text" :id="`name-${index}`" class="form-control" v-model="options[index].name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label :for="`type-${index}`">Type</label>
                                    <select class="form-control" :id="`type-${index}`" v-model="options[index].type">
                                        <option value="color">Color</option>
                                        <option value="dropdown">Dropdown</option>
                                        <option value="radiobutton">Radio button</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group switch-wrapper">
                                    <div class="custom-control custom-switch">
                                        <input
                                            type="checkbox"
                                            :id="`is_required-${index}`"
                                            class="custom-control-input"
                                            v-model="options[index].is_required"
                                        />
                                        <label :for="`is_required-${index}`" class="custom-control-label"
                                            >Required</label
                                        >
                                        </div>
                                </div>
                            </div>
                        </div>
                        <option-value :type="option.type" @updateValues="options[index].values = $event" :option="options[index]"></option-value>
                    </div>
                  </div>
              </div>
          </draggable>
      </div>
      <p v-else>No options found!</p>
  </div>
</template>

<script>
import draggable from 'vuedraggable'

import OptionValue from './OptionValue.vue'
export default {
    name: 'ProductOptions',
    props: ['oldOptions'],
    components: {
        draggable,
        OptionValue
    },
    data() {
        return {
            options: [],
            sorted: [],
            isSorted: false,
        }
    },
    computed: {
        position() {
            if(this.options.length) {
                return this.options.length + 1;
            } else {
                return 1;
            }
        }
    },
    methods: {
        addNewOption() {
            this.options.push({
                name: null,
                type: 'radiobutton',
                is_required: true,
                position: this.position,
                values: []
            })
        },
         removeOption(index) {
             if(index != null){
                 this.options.splice(index, 1)
             }
         },
         sortList(e) {
             if(!this.isSorted) {
                 const sorted = this.options;
                 sorted.forEach((option, index) => option.position = index + 1 )
                 this.sorted = sorted;

                 this.isSorted = true;
             }
         }
    },
    watch: {
        options(oldVal, newVal) {
            this.$emit('update', oldVal)
        }
    },
    created() {
        if(this.oldOptions && this.oldOptions.length) {
            this.options = this.oldOptions
        }
    }
}
</script>

<style>
    .remove {
        color: #999;
    }

    .remove:hover {
        color: #444;
        cursor: pointer;
    }

</style>