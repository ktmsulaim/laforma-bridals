<template>
  <div class="wrapper">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div
            id="uploader"
            class="card-body d-flex align-items-center justify-content-center"
          >
            <file-uploader
              :listenToUpdates="true"
              @upload="updateList"
            ></file-uploader>
          </div>
        </div>
      </div>
    </div>
    <div v-if="images.all.length" class="row tools my-2">
        <div class="col-md-4">
            <select v-model="pageSize" @change="updatePage" class="form-control">
                <option value=4>4</option>
                <option value=8>8</option>
                <option value=12>12</option>
                <option value=25>25</option>
                <option value=50>50</option>
                <option value=100>100</option>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-secondary" @click="editImage">
                <span v-if="edit.status">Cancel</span>
                <span v-else>Edit</span>
            </button>
            <button class="btn btn-link ml-2" @click="selectAll" v-if="edit.status">
                <span v-if="edit.selectAll">Deselect all</span>
                <span v-else>Select all</span>
            </button>
            <button class="btn btn-danger ml-2" @click="confirmDelete" v-if="edit.status" :disabled="!edit.selected.length">Delete</button>
        </div>
        <div class="col-md-4 text-right" v-if="edit.status">
            <p class="small">{{ edit.selected.length }} image(s) selected</p>
        </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <div v-if="loading">
          <div class="row">
            <div
              class="col-md-3"
              v-for="(loadingItem, index) in 4"
              :key="index"
            >
                  <vue-skeleton-loader
                    type="rect"
                    width="100%"
                    height="180px"
                    rounded
                    radius="8px"
                    animation="wave"
                  />
            </div>
          </div>
        </div>
        <div v-else-if="images.all.length">
          <div class="row" v-if="images.display.length">
            <div
              class="col-md-3"
              v-for="image in images.display"
              :key="image.id"
            >
             <single-image :image="image"></single-image>
            </div>
          </div>
          <div class="row mt-2">
            <jw-pagination
              :items="images.all"
              @changePage="changePage"
              :pageSize="parseInt(pageSize)"
              ref="pagination"
            ></jw-pagination>
          </div>
        </div>
        <div v-else>
          <p>No images found!</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FileUploader from "../FileUploader.vue";
import SingleImage from './SingleImage.vue'

import { mapState } from 'vuex'

export default {
  name: "ListMedia",
  components: {
    FileUploader,
    SingleImage
  },
  data() {
    return {
      grid: null,
      loading: false,
      pageSize: 12,
      images: {
        all: [],
        display: [],
      }
    };
  },
  computed:{
    ...mapState({
      edit: state => state.Media.edit
    })
  },
  methods: {
    changePage(images) {
      this.images.display = images;
    },
    updateList() {
      this.fetchImages()
    },
    fetchImages() {
        this.loading = true;

        axios.get(route('admin.images.list'))
        .then(resp => {
            this.images.all = resp.data
            this.$nextTick(() => {
                $(".image-popup").magnificPopup({ type: "image", closeOnContentClick: !0, mainClass: "mfp-fade", gallery: { enabled: !0, navigateByImgClick: !0, preload: [0, 1] } });
            })
            }
        )
        .catch(err => toastr.error('Unable to load images', 'Failed'))
        .finally(() => this.loading = false)
    },
    updatePage() {
        if(this.pageSize) {
            const page = parseInt(this.pageSize);

            this.$nextTick(() => {
                this.$refs.pagination.pageMax = page;
                this.$refs.pagination.setPage(1);
            })

        }
    },
    editImage() {
        if(this.edit.status) {
            this.$store.commit('changeEditStatus', {status: false});
        } else {
            this.$store.commit('changeEditStatus', {status: true});
        }
    },
    selectAll(){
        this.$store.commit('changeEditStatus', {key: 'selectAll', status: !this.edit.selectAll})

        if(this.edit.selectAll) {
          this.$store.commit('selectAll', this.images.all.map(image => image.id))
        } else {
          this.$store.commit('selectAll', [])
        }
    },
    cancelEdit() {
        this.$store.commit('changeEditStatus', {status: false});
    },
    confirmDelete(){
        this.$swal({
            titleText: 'Are you sure?',
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: 'Proceed',
            confirmButtonColor: '#ff5b5b',
        })
        .then(result => {
            if(result.isConfirmed) {
                axios.delete(route('admin.images.destroy'), {
                    data: {
                        data: this.edit.selected
                    }
                })
                .then(resp => {
                    this.$swal('The image(s) has been deleted', '', 'success')
                    this.cancelEdit();
                    this.fetchImages();

                })
                .catch(error => {
                    this.$swal('Sorry! Unable to delete the image(s)', '', 'error')
                })
            }
        })
        .catch(error => {
            this.$swal('Sorry! Unable to delete the image(s). Try again later', '', 'error')
        })
    },
  },
  created() {
      this.fetchImages()
  },
};
</script>

<style scoped>
#uploader {
  min-height: 200px;
}
</style>