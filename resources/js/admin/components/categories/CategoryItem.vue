<template>
  <div v-if="hasChildren">
      <categories v-for="(child, index) in category.children_recursive" :key="index" :category="child"></categories>
  </div>
</template>

<script>
import Categories from './Categories.vue'

export default {
    name: 'CategoryItem',
    props: ['category'],
    components: {
        Categories
    },
    computed: {
        hasChildren() {
            return this.category && this.category.children_recursive && this.category.children_recursive.length;
        }
    }
}
</script>

<style>

</style>