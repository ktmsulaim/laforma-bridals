<template>
  <div>
      <label for="package">Package</label>
      <select @change="sendValue" :disabled="loading" name="package" id="package" class="form-control" v-model="packages">
          <option v-if="loading" selected>Loading...</option>
          <option v-for="(packages, index) in packagesList" :key="index" :value="packages.name">{{ packages.name }}</option>
      </select>
  </div>
</template>

<script>
export default {
    name: 'PackageList',
    data() {
        return {
            packages: null,
            packagesList: [],
            loading: true,
        }
    },
    methods: {
        sendValue() {
            this.$emit('set', this.packages)
        },
        clear() {
            this.packages = null;
        }
    },
    created() {
        axios.get(route('admin.packages.index'))
        .then(resp => this.packagesList = resp.data)
        .catch(err => console.error(err))
        .finally(() => this.loading = false)
    }
}
</script>

<style>

</style>