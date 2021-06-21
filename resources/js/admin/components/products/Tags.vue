<template>
  <div class="from-group">
        <label for="tags">Tags</label>
        <select2
            v-model="selected"
            :options="tagsList"
            @select="updateTags"
            :settings="{
                placeholder: 'Select a tag',
                width: '100%',
                multiple: true,
            }"
        ></select2>
    </div>
</template>

<script>
import Select2 from "v-select2-component";

export default {
    name: 'Tags',
    props: ['product'],
    data() {
        return {
            tags: [],
            selected: null,
        }
    },
    components: {
        Select2
    },
    computed: {
        productId() {
            if(this.product) {
                return this.product.id;
            } else {
                return 0;
            }
        },
        tagsList() {          
          if(this.tags && this.tags.length) {
              return this.tags.map(tag => {
                  return {
                      id: tag.id,
                      text: tag.name
                  }
              })
          }
        },
        
    },
    methods:{
        fetchTags() {
            axios.get(route('admin.tags.list'))
            .then(resp => this.tags = resp.data)
            .catch(err => toastr.error('Unable to fetch tags', 'Error'))
        },
        updateTags() {
            this.$emit('select', this.selected)
        }
    },
    mounted() {
        if(this.product && this.product.tags && this.product.tags.length) {
            this.selected = this.product.tags.map(tag => tag.id)
        }
    },
    created() {
       this.fetchTags()
    }
}
</script>

<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #71b6f9;
    border: 1px solid #63acf7;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #fdfdfd;
}
</style>