<template>
  <div class="card" v-if="hasErrors">
      <div class="card-body">
          <h4 class="card-title text-danger">Errors</h4>
          <div class="mt-4">
              <ul class="text-danger">
                  <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
          </div>
      </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    name: "Errors",
    computed: {
        ...mapGetters({
            'errors': 'getErrors',
        }),
        hasErrors(){
            return this.errors && Object.keys(this.errors).length > 0;
        }
    },
    watch: {
        errors: {
            handler: (oldVal, newVal) => {
                
            },
        }
    }
}
</script>

<style>

</style>