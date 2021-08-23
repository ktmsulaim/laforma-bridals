<template>
  <div>
      <p>
          <strong>Select brand images</strong>
      </p>
      <file-manager type="additional_images" additionalImagesName="brands_images" :oldAdditionalImages="brands"></file-manager>
  </div>
</template>

<script>
import FileManager from '../FileManager.vue'
export default {
    name: 'SelectBrands',
    components: {
        FileManager,
    },
    props: ['brands'],
}
</script>

<style>

</style>