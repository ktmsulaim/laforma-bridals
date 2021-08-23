<template>
  <div>
      <select2
      :settings="settings"
      id="featured_product_id"
      name="featured_product_id"
      v-model="selected"
    ></select2>
    <div class="mt-2">
        <p>
            <strong>Background Image (1200x800)</strong>
        </p>
        <file-manager type="base_image" :oldBaseImage="oldBaseImage" baseImageName="featured_product_image"></file-manager>
    </div>
  </div>
</template>

<script>
import Select2 from "v-select2-component";
import FileManager from '../FileManager.vue'

export default {
    name: "SelectFeaturedProduct",
    components: {
        Select2,
        FileManager,
    },
    props: ['value', 'image'],
    data() {
        return {
            selected: null,
            products: [],
            settings:{
                placeholder: 'Search a product',
                width: '100%',
                ajax: {
                    url: route('admin.products.list'),
                    processResults: (data) => {
                        if(this.value && data) {
                            const selected = data.find(product => product.id == this.value)

                            if(selected) {
                                // preselect selected option
                                const option = new Option(selected.name, selected.id, false, false)
                                $('#featured_product_id').append(option).trigger('select')
                            }
                        }
                    // transforming data to seletable options
                        return {
                            results: data ? data.map(product => ({id: product.id, text: product.name})) : []
                        };
                    }
                }
            }
        }
    },
    computed: {
        oldBaseImage() {
            if(this.image) {
                return this.image;
            }
        }
    },
    created() {
        if(this.value) {
            this.selected = this.value
        }
    }
}
</script>

<style>

</style>