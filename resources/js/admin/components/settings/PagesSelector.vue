<template>
  <div class="w-100">
    <select2
      :options="pagesOptions"
      :settings="{
        placeholder: 'Select a page',
        width: '100%',
      }"
      :name="name"
      v-model="selected"
    ></select2>
  </div>
</template>

<script>
import Select2 from "v-select2-component";
export default {
  name: "PageSelector",
  props: ["pages", "name", "value"],
  components: {
    Select2,
  },
  data() {
    return {
      selected: null,
    };
  },
  computed: {
    pagesOptions() {
      if (this.pages && this.pages.length) {
        return this.pages.map((page) => ({ id: page.slug, text: page.title }));
      }
    },
  },
  created() {
    if (this.value) {
      this.selected = this.value;
    }
  },
};
</script>

<style>
</style>