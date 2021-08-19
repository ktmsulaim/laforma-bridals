<template>
  <div v-if="loading" class="row small-gutters">
    <div
      v-for="(item, index) in 4"
      :key="index"
      class="col-6 col-lg-3 col-md-4 mt-2"
    >
      <vue-skeleton-loader
        type="rect"
        width="100%"
        height="200px"
        animation="wave"
      />
    </div>
  </div>
  <stack
    v-else-if="images"
    :columnMinWidth="200"
    monitor-images-loaded
    class="image-stack"
    :gutter-width="15"
    :gutter-height="15"
  >
    <stack-item
      v-for="(image, index) in images"
      :key="index"
      class="image gallery-images"
    >
      <a :href="image.path" :title="image.filename" class="image-link">
        <img :src="image.path" class="img-fluid" :alt="image.filename" />
      </a>
    </stack-item>
  </stack>
  <no-data v-else :size="100" type="images"></no-data>
</template>

<script>
import NoData from "../NoData.vue";
import { Stack, StackItem } from "vue-stack-grid";
export default {
  name: "LatestCollection",
  props: ["id"],
  components: {
    NoData,
    Stack,
    StackItem,
  },
  data() {
    return {
      loading: false,
      images: [],
    };
  },
  methods: {
    fetchImages() {
      this.loading = true;
      axios
        .get(route("collections.byCollection", { id: this.id }))
        .then((resp) => {
          this.images = resp.data;

          this.$nextTick(() => {
            $(function () {
              $(".image-link").magnificPopup({
                type: "image",
                gallery: { enabled: true },
              });
            });
          });
        })
        .catch((err) =>
          this.$toast.open({
            message: "Unable to load the images",
            type: "error",
          })
        )
        .finally(() => (this.loading = false));
    },
  },
  created() {
    this.fetchImages();
  },
};
</script>

<style>
</style>