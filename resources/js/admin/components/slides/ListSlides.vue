<template>
  <loading v-if="loading"></loading>
  <div class="row" v-else-if="slidesData">
    <draggable class="row" v-model="slides" @end="sortList" handle=".slide">
      <div
        v-for="(slide, index) in slides"
        :key="index"
        class="col-lg-3 col-md-4"
      >
        <div class="slide">
          <div class="slide-image">
            <img :src="slide.base_image.path" alt="Image" />
          </div>
          <div class="slide-meta">
            <button
            @click="changeStatus(slide.id, slide.status)"
            :disabled="status.loading && status.selected == slide.id"
              class="btn btn-xs"
              :class="{
                'btn-success': slide.status === 1,
                'btn-danger': slide.status === 0,
              }"
            >
              <span v-if="status.loading && status.selected == slide.id">
                <i class="mdi mdi-spin mdi-loading"></i>
                <span>Processing</span>
              </span>
              <span v-else-if="slide.status === 1">Published</span>
              <span v-else-if="slide.status === 0">Draft</span>
            </button>
            <button @click="edit(slide.id)" class="btn btn-xs btn-info">
              <i class="mdi mdi-pencil"></i>
              <span>Edit</span>
            </button>
          </div>
        </div>
      </div>
    </draggable>

    <!-- Pagination -->
    <div class="col-12 mt-2">
      <pagination
        :data="slidesData"
        @pagination-change-page="fetchSlides"
        align="center"
      ></pagination>
    </div>
  </div>
  <div class="row" v-else>
    <div class="col-12">
      <p>No slides found!</p>
    </div>
  </div>
</template>

<script>
import Loading from "../Loading.vue";
import Draggable from "vuedraggable";
export default {
  name: "ListSlides",
  components: {
    Loading,
    Draggable,
  },
  data() {
    return {
      loading: false,
      slidesData: {},
      slides: [],
      sorted: [],
      status: {
        loading: false,
        id: null,
      },
    };
  },
  computed: {
  
  },
  methods: {
    fetchSlides(page = 1) {
      this.loading = true;

      axios
        .get(route("admin.slides.list", { page }))
        .then((resp) => {
          this.slidesData = resp.data
          this.slides = resp.data.data
        })
        .catch((err) => taostr.error("Unable to load slides", "Error"))
        .finally(() => (this.loading = false));
    },
    edit(id) {
      if (id) {
        window.location = route("admin.slides.edit", { id });
      }
    },
    sortList(e) {
      const sorted = this.slides;
      
      if(sorted) {
        this.sorted = sorted.map((slide, index) => {
          return {id: slide.id, position: index +1};
        })

        if(this.sorted && this.sorted.length) {
          axios.post(route('admin.slides.sort'), {slides: this.sorted})
          .catch(err => taostr.error('Unable to sort the slides', 'Error'))
        }
      }
    },
    changeStatus(id, status) {
      const newStatus = status === 1 ? 0 : 1;

      if(id) {
        this.status.loading = true;
        this.status.id = id;

        axios.patch(route('admin.slides.update', id), {status: newStatus})
        .then(resp => {
          const slide = this.slidesData.data.find(sld => sld.id === id)

          if(slide) {
            slide.status = newStatus;
          }
        })
        .catch(err => toastr.error('Unable to change the status', 'Error'))
        .finally(() => {
          this.status.loading = false;
          this.status.id = null;
        })
      }
    }
  },
  mounted() {
    this.fetchSlides();
  },
};
</script>

<style>
</style>