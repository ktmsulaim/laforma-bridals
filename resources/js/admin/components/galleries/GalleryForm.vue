<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <div>
            <p>
              <strong>Cover photo</strong>
            </p>
            <file-manager
              :oldBaseImage="oldBaseImage"
              @selectImage="updateImage"
              type="base_image"
            ></file-manager>
          </div>
          <hr />
          <div>
            <p>
              <strong>Images</strong>
            </p>
            <file-manager
              :oldAdditionalImages="oldAdditionalImages"
              @selectImage="updateImage"
              type="additional_images"
            ></file-manager>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <errors></errors>
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input
              type="text"
              id="name"
              class="form-control"
              @input="updateSlug('name', 'slug')"
              v-model="data.name"
              :class="{ 'is-invalid': hasError('name') }"
            />
          </div>
          <div class="form-group">
            <label for="slug">Slug <span class="text-danger">*</span></label>
            <input
              type="text"
              id="slug"
              class="form-control"
              @input="updateSlug('slug', 'slug')"
              v-model="data.slug"
              :class="{ 'is-invalid': hasError('slug') }"
            />
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea
              type="text"
              id="description"
              class="form-control"
              v-model="data.description"
              :class="{ 'is-invalid': hasError('description') }"
            >
            </textarea>
          </div>
          <div>
            <div class="custom-control custom-switch">
              <input
                type="checkbox"
                id="status"
                class="custom-control-input"
                v-model="data.status"
              />
              <label for="status" class="custom-control-label">Enable</label>
            </div>
          </div>
          <div class="mt-2">
              <button @click="submit" class="btn btn-primary" :disabled="hasErrors || loading">
                  <span v-if="loading">
                      <i class="mdi mdi-spin mdi-loading"></i>
                      Processing
                  </span>
                  <span v-else>Submit</span>
              </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ErrorsMixin from "../../mixins/errorsMixin";
import slugMixin from "../../mixins/slugMixin";
import FileManager from "../FileManager.vue";

export default {
  name: "GalleryForm",
  props: {
    mode: {
      type: String,
      required: true,
      default: "create",
    },
    gallery: {
      type: Object,
      required: false,
    },
  },
  mixins: [ErrorsMixin, slugMixin],
  components: {
    FileManager,
  },
  data() {
    return {
    loading: false,
      data: {
        name: null,
        slug: null,
        description: null,
        status: 1,
        thumbnail: null,
        images: [],
      },
      validations: {
        name: "required",
        slug: "required",
        description: null,
        status: null,
        thumbnail: "required",
        images: "required",
      },
    };
  },
  computed: {
      oldBaseImage() {
      if (this.mode == "edit" && this.gallery) {
        return this.gallery.base_image;
      }
    },
    oldAdditionalImages() {
      if (this.mode == "edit" && this.gallery) {
        return this.gallery.additional_images;
      }
    },
  },
  methods: {
    updateImage(value) {
      if (value.type == "base_image") {
        this.data.thumbnail = value.id;
      } else if (value.type == "additional_images") {
        this.data.images = value.ids;
      }
    },
    submit() {
        let url, method;
        
        this.loading = true;
        
        if(this.mode === 'create') {
            url = route('admin.galleries.store');
            method = 'POST'
        } else if(this.mode === 'edit' && this.gallery) {
            url = route('admin.galleries.update', this.gallery.id);
            method = 'PATCH'
        }

        axios({method, url, data: this.data})
        .then(resp => {
            toastr.success(`The gallery has been ${this.mode === 'create' ? 'created' : 'saved'}`)
            window.location = route('admin.galleries.index')
        })
        .catch(err => {
            toastr.error(`Unable to ${this.mode} the gallery`, 'Failed')
        })
        .finally(() => {
            this.loading = false;
        })
    }
  },
  created() {
      if(this.mode === 'edit' && this.gallery) {
          this.data.name = this.gallery.name;
          this.data.slug = this.gallery.slug;
          this.data.description = this.gallery.description;
          this.data.status = this.gallery.status;
      }
  }
};
</script>

<style>
</style>