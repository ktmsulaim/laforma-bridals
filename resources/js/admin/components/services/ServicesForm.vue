<template>
  <div class="card">
    <div class="card-body">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a
            href="#general"
            data-toggle="tab"
            aria-expanded="false"
            class="nav-link active"
          >
            <span class="d-none d-sm-block">General</span>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="#price"
            data-toggle="tab"
            aria-expanded="true"
            class="nav-link"
          >
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">Price</span>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="#features"
            data-toggle="tab"
            aria-expanded="false"
            class="nav-link"
          >
            <span class="d-block d-sm-none"
              ><i class="far fa-envelope"></i
            ></span>
            <span class="d-none d-sm-block">Features</span>
          </a>
        </li>
        <li class="nav-item">
          <a
            href="#images"
            data-toggle="tab"
            aria-expanded="false"
            class="nav-link"
          >
            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
            <span class="d-none d-sm-block">Images</span>
          </a>
        </li>
      </ul>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="general">
          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input
              type="text"
              name="name"
              class="form-control"
              v-model="data.name"
              @input="updateSlug('name', 'slug')"
              :class="{ 'is-invalid': hasError('name') }"
            />
          </div>

          <div class="form-group">
            <label for="slug">Slug</label>
            <input
              type="text"
              name="slug"
              class="form-control"
              v-model="data.slug"
            />
          </div>

          <div class="form-group">
            <label for="description"
              >Description <span class="text-danger">*</span></label
            >
            <quill-editor
              ref="descriptionEditor"
              v-model="data.description"
              :options="editorOption"
              :class="{ 'is-invalid': hasError('description') }"
            />
          </div>

          <div class="row mt-2">
            <div class="col-md-6">
              <div class="from-group">
                <label for="hours">Hours <span class="text-danger">*</span></label>
                <input type="number" name="hours" id="hours" class="form-control" min="0.01" step="0.1" v-model="data.hours">
              </div>
            </div>
            <div class="col-md-6">
              <div class="from-group">
                <label for="status"
                  >Status <span class="text-danger">*</span></label
                >
                <select
                  v-model="data.status"
                  id="status-select"
                  class="form-control"
                  required
                >
                  <option value="1">Enabled</option>
                  <option value="0">Disalbed</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="price">
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <label for="price">Price</label>
                <input
                  type="number"
                  name="price"
                  id="price"
                  min="1"
                  class="form-control"
                  v-model="data.price"
                  required
                />
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="special_price">Special price</label>
                <input
                  type="number"
                  name="special_price"
                  id="special_price"
                  v-model="data.special_price"
                  min="1"
                  class="form-control"
                />
              </div>
              <div class="col-md-6">
                <label for="special_price_type">Special price type</label>
                <select
                  name="special_price_type"
                  id="special_price_type"
                  v-model="data.special_price_type"
                  class="form-control"
                >
                  <option value="fixed">Fixed</option>
                  <option value="percentage">Percentage</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="special_price_start">Special price start</label>
                <date-picker
                  value-type="format"
                  input-class="form-control"
                  v-model="data.special_price_start"
                ></date-picker>
              </div>
              <div class="col-md-6">
                <label for="special_price_end">Special price end</label>
                <date-picker
                  value-type="format"
                  input-class="form-control"
                  v-model="data.special_price_end"
                ></date-picker>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="features">
          <features :oldFeatures="service ? service.features : null" @saved="updateFeatures"></features>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="images">
          <div>
            <p>
              <strong>Base image</strong>
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
              <strong>Additional images</strong>
            </p>
            <file-manager
              :oldAdditionalImages="oldAdditionalImages"
              @selectImage="updateImage"
              type="additional_images"
            ></file-manager>
          </div>
        </div>
      </div>
      <div class="mt-2">
        <button
          type="button"
          :disabled="hasErrors || loading"
          @click="submit"
          class="btn btn-primary"
        >
          <span v-if="loading">
            <i class="mdi mdi-spin mdi-loading"></i>
            <span class="ml-1">Processing</span>
          </span>
          <span v-else>Save</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

import Features from './Features.vue'

import ErrorsMixin from "../../mixins/errorsMixin";
import slugMixin from "../../mixins/slugMixin";

export default {
  name: "ServicesForm",
  mixins: [ErrorsMixin, slugMixin],
  components: {
    DatePicker,
    Features
  },
  props: {
    mode: {
      default: "create",
      type: String,
      required: true,
    },
    service: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      loading: false,
      data: {
        name: null,
        slug: null,
        description: null,
        features: [],
        hours: 1,
        price: 1,
        special_price: null,
        special_price_type: "fixed",
        special_price_start: null,
        special_price_end: null,
        status: 1,
        base_image: null,
        additional_images: [],
      },
      validations: {
        name: "required",
        description: "required",
        features: "required",
        hours: "required",
        price: "required",
        base_image: "required",
      },
      editorOption: {
        theme: "snow",
      },
    };
  },
  methods: {
    submit() {
      this.loading = true;
      let url;

      if (this.mode == "create") {
        url = route("admin.services.store");
      } else {
        url = route("admin.services.update", this.service.id);
      }

      axios({
        method: this.mode == "edit" ? "PATCH" : "POST",
        url,
        data: this.data,
      })
        .then((resp) => {
          toastr.success(
            `The service has been ${
              this.mode == "create" ? "created" : "saved"
            }`,
            "Success"
          );
          window.location = route("admin.services.index");
        })
        .catch((err) => toastr.error(`Unable to ${this.mode} the service`, 'Failed'))
        .finally(() => {
          this.loading = false;
        });
    },
    updateImage(value) {
      if (value.type == "base_image") {
        this.data.base_image = value.id;
      } else if (value.type == "additional_images") {
        this.data.additional_images = value.ids;
      }
    },
    updateFeatures(value) {
      this.data.features = value;
    }
  },
  computed: {
    oldBaseImage() {
      if (this.mode == "edit" && this.service) {
        return this.service.base_image;
      }
    },
    oldAdditionalImages() {
      if (this.mode == "edit" && this.service) {
        return this.service.additional_images;
      }
    },
  },
  created() {
    if(this.mode == 'edit' && this.service && Object.keys(this.service).length) {
      this.data = {
        name: this.service.name,
        slug: this.service.slug,
        description: this.service.description,
        hours: this.service.hours,
        price: this.service.price,
        special_price: this.service.special_price,
        special_price_type: this.service.special_price_type,
        special_price_start: this.service.special_price_start,
        special_price_end: this.service.special_price_end,
        status: this.service.status,
        base_image: this.service.base_image ? this.service.base_image.id : null,
        additional_images: this.service.additional_images ? this.service.additional_images.map(image => image.id) : [],
      };
    }
  }
};
</script>

<style>
</style>