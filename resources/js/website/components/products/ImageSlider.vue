<template>
  <div v-if="images && images.length" class="owl-carousel owl-theme prod_pics magnific-gallery">
        <div class="item" v-for="(image, index) in images" :key="index">
            <a :href="image" data-effect="mfp-zoom-in"
                ><img :src="image" alt=""/>
            </a>
        </div>
    <!-- /item -->
  </div>
  <div v-else class="owl-carousel owl-theme prod_pics magnific-gallery">
    <div class="item">
      <img
        src="/img/970x610.png"
        data-src="/img/970x610.png"
        alt=""
        class="owl-lazy"
      />
    </div>
    <!-- /item -->
  </div>
  <!-- /carousel -->
</template>

<script>
import ImageSliderMixin from '../../mixins/imageSliderMixin'
export default {
    name: 'ImageSlider',
    props: ['images'],
    mixins: [ImageSliderMixin],
};
</script>

<style></style>
