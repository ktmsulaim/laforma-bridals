<template>
  <div>
    <div class="btn btn-info" @click="showFileManager">
      <span class="mdi mdi-folder-open"></span> Browse
    </div>

    <div v-if="baseImage">
      <input type="hidden" name="base_image" :value="baseImage.id" />
      <div class="thumb">
        <img :src="baseImage.path" alt="" width="200" />
      </div>
    </div>
    <div v-else-if="additional_images && additional_images.length > 0">
      <div class="row">
        <div
          v-for="image in additional_images"
          :key="image.id"
          class="col-md-3"
        >
          <input type="hidden" name="additional_images[]" :value="image.id" />
          <div class="gal-detail thumb">
            <div class="image-popup" :title="image.filename">
              <img
                :src="image.path"
                class="thumb-img img-fluid"
                alt="work-thumbnail"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      ref="filemanager"
      class="modal media-file-picker fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="fileuploader"
      aria-hidden="true"
      style="display: none"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="fileuploader">File Manager</h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-hidden="true"
            >
              ×
            </button>
          </div>
          <div ref="modalBody" class="modal-body">
            <ul class="nav nav-tabs">
              <li class="nav-item" @click="clearUploads">
                <a
                  :href="`#upload-${type}`"
                  data-toggle="tab"
                  aria-expanded="false"
                  class="nav-link active"
                >
                  <span class="d-block d-sm-none"
                    ><i class="fas fa-home"></i
                  ></span>
                  <span class="d-none d-sm-block">Upload</span>
                </a>
              </li>
              <li class="nav-item" @click="fetchImages">
                <a
                  :href="`#media-library-${type}`"
                  data-toggle="tab"
                  aria-expanded="true"
                  class="nav-link"
                >
                  <span class="d-block d-sm-none"
                    ><i class="far fa-user"></i
                  ></span>
                  <span class="d-none d-sm-block">Media library</span>
                </a>
              </li>
            </ul>

            <div class="tab-content">
              <div
                role="tabpanel"
                class="tab-pane fade show active"
                :id="`upload-${type}`"
              >
                <div class="d-flex justify-content-center align-items-center">
                  <file-uploader ref="fileUploader"></file-uploader>
                </div>
              </div>
              <div
                role="tabpanel"
                class="tab-pane fade"
                :id="`media-library-${type}`"
              >
                <div class="row">
                  <div class="col-md-9">
                    <div class="row" v-if="loading">
                      <div class="col-md-2">
                        <vue-skeleton-loader
                          type="rect"
                          :width="100"
                          :height="100"
                          animation="fade"
                        />
                      </div>
                      <div class="col-md-2">
                        <vue-skeleton-loader
                          type="rect"
                          :width="100"
                          :height="100"
                          animation="fade"
                        />
                      </div>
                      <div class="col-md-2">
                        <vue-skeleton-loader
                          type="rect"
                          :width="100"
                          :height="100"
                          animation="fade"
                        />
                      </div>
                      <div class="col-md-2">
                        <vue-skeleton-loader
                          type="rect"
                          :width="100"
                          :height="100"
                          animation="fade"
                        />
                      </div>
                      <div class="col-md-2">
                        <vue-skeleton-loader
                          type="rect"
                          :width="100"
                          :height="100"
                          animation="fade"
                        />
                      </div>
                      <div class="col-md-2">
                        <vue-skeleton-loader
                          type="rect"
                          :width="100"
                          :height="100"
                          animation="fade"
                        />
                      </div>
                    </div>
                    <div class="row" v-else-if="files.images">
                      <div
                        class="col-md-3"
                        v-for="image in files.images"
                        :key="image.id"
                      >
                        <div
                          @click="select(image)"
                          class="gal-detail thumb"
                          :class="hasSelected(image) ? 'selected' : ''"
                        >
                          <div class="image-popup" :title="image.filename">
                            <img
                              :src="image.path"
                              class="thumb-img img-fluid"
                              alt="work-thumbnail"
                            />
                          </div>
                        </div>
                      </div>
                      <div
                        ref="loadMoreButton"
                        v-if="loadMore.hasMore"
                        class="col-md-12 my-3 text-center"
                      >
                        <button class="btn btn-secondary btn-sm" @click="loadMoreImages">
                          Load more
                        </button>
                      </div>
                      <div class="col-12 mt-4">
                        <p class="text-muted small m-0">
                          Showing
                          {{ files.images.length }} / {{ totalImages }} images
                        </p>
                      </div>
                    </div>
                    <div class="row" v-else>
                      <div class="col">
                        <p class="text-muted">No images found!</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div v-if="hasSelectedImage" class="bg-light p-2">
                      <div v-if="type == 'base_image' && baseImage">
                        <b>Selected image:</b>
                        <div class="image mt-2">
                          <img
                            :src="baseImage.path"
                            :alt="baseImage.filename"
                            class="img-fluid"
                          />
                        </div>
                        <div class="mt-2">
                          <p>
                            <b>Filename: </b>
                            <span v-text="baseImage.filename"></span>
                          </p>
                          <p>
                            <b>Path: </b>
                            <span v-text="baseImage.path"></span>
                          </p>
                          <p>
                            <b>Size: </b>
                            <span v-text="baseImage.size"></span>
                          </p>
                        </div>
                      </div>
                      <div v-else-if="type == 'additional_images'">
                        <p>
                          <b>Selected images:</b>
                        </p>
                        {{ additional_images.length }} images selected

                        <div class="mt-2" v-if="additional_images.length > 0">
                          <button class="btn btn-sm btn-link" @click="additional_images = []">Deselect all</button>
                          <button class="btn btn-sm btn-link">Show selected</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" v-if="hasSelectedImage">
            <button @click="closeFileManager" class="btn btn-primary">
              Save
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </div>
</template>

<script>
import FileUploader from "./FileUploader.vue";

export default {
  name: "FileManager",
  props: ["type"],
  components: {
    FileUploader,
  },
  data() {
    return {
      baseImage: null,
      additional_images: [],
      loading: true,
      files: {
        images: [],
      },
      loadMore: {
        status: true,
        hasMore: false,
        currentCoordsLeft: 0,
        currentCoordsTop: 0,
      },
      totalImages: 0,
    };
  },
  methods: {
    showFileManager() {
      $(this.$refs.filemanager).modal("show");
    },
    getTotalImages() {
      axios
        .get(route("admin.images.index", { count: true }))
        .then((resp) => (this.totalImages = resp.data))
        .catch((err) => console.error(err));
    },
    fetchImages() {
      this.loading = true;
      axios
        .get(
          route("admin.images.index", {
            offset: this.offset,
            limit: this.limit,
          })
        )
        .then((resp) => {
          const data = resp.data;
          if(data && data.length > 0) {
            // Push all fetched images to file.images
            data.forEach(img => this.files.images.push(img))
            
            // Filter duplicate entries
            this.files.images = _.uniqBy(this.files.images, function(image){
              return image.id;
            });
          }

            this.$nextTick(() => {
              if(this.loadMore.status == true) {
                this.$refs.modalBody.scrollTo(this.loadMore.currentCoordsLeft, this.loadMore.currentCoordsTop - 10)
              }

              // Sort by id to see last uploaded
              this.files.images = _.orderBy(this.files.images, ['id']['desc']);
            })
        }
        )
        .catch((err) => console.error(err))
        .finally(() => {
          if (this.totalImages && this.files.images.length) {
            if (this.totalImages > this.files.images.length) {
              this.loadMore.hasMore = true;
            } else {
              this.loadMore.hasMore = false;
            }
          }

          this.getTotalImages();

          this.loading = false;
        });
    },
    select(image) {
      if (this.type == "base_image") {
        if (this.baseImage && this.baseImage == image) {
          this.baseImage = null;
        } else {
          this.baseImage = image;
          this.$emit('selectImage', {type: 'base_image', id: image.id});
        }
      } else if (this.type == "additional_images") {
        if (this.additional_images.includes(image)) {
          const index = this.additional_images.indexOf(image);

          if (index != -1) {
            this.additional_images.splice(index, 1);
          }
        } else {
          this.additional_images.push(image);
          this.$emit('selectImage', {type: 'additional_images', ids: this.additional_images.map(img => img.id)});
        }
      }
    },
    closeFileManager() {
      $(this.$refs.filemanager).modal("hide");
    },
    hasSelected(image) {
      if (this.type == "base_image" && image == this.baseImage) {
        return true;
      } else if (
        this.type == "additional_images" &&
        this.additional_images.includes(image)
      ) {
        return true;
      } else {
        return false;
      }
    },
    loadMoreImages() {
      this.loadMore.status = true;
      this.loadMore.currentCoordsLeft = this.$refs.loadMoreButton.offsetLeft;
      this.loadMore.currentCoordsTop = this.$refs.loadMoreButton.offsetTop;
      this.fetchImages();
    },
    clearUploads() {
      this.$refs.fileUploader.clearUploads();
    }
  },
  computed: {
    offset() {
      if (
        this.loadMore.hasMore &&
        this.files.images &&
        this.files.images.length > 0
      ) {
        return this.files.images.length;
      } else {
        return 0;
      }
    },
    limit() {
      return 20;
    },
    hasSelectedImage() {
      if (this.type == "base_image") {
        return this.baseImage != null;
      } else if (this.type == "additional_images") {
        return this.additional_images.length > 0;
      }
    },
  },
  created() {
    this.getTotalImages();
  },
};
</script>

<style></style>
