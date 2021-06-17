<template>
  <div>
      <label for="tags">Tags</label>
      <input type="text" name="tags" id="tags" data-role="tagsinput">
  </div>
</template>

<script>
export default {
    name: 'Tags',
    props: ['product'],
    computed: {
        productId() {
            if(this.product) {
                return this.product.id;
            } else {
                return 1;
            }
        }
    },
    created() {
        if(this.product) {
            
        }
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