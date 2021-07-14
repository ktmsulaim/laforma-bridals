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
                <label for="booking_price">Booking price</label>
                <input
                  type="number"
                  name="booking_price"
                  id="booking_price"
                  v-model="data.booking_price"
                  min="1"
                  class="form-control"
                />
              </div>
              <div class="col-md-6">
                <label for="booking_price_type">Booking price type</label>
                <select
                  name="booking_price_type"
                  id="booking_price_type"
                  v-model="data.booking_price_type"
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
                  :disabled-date="disabledDates"
                ></date-picker>
              </div>
              <div class="col-md-6">
                <label for="special_price_end">Special price end</label>
                <date-picker
                  value-type="format"
                  input-class="form-control"
                  v-model="data.special_price_end"
                  :disabled-date="disabledDates"
                ></date-picker>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="features">
          <features :oldFeatures="packages ? packages.features : null" @saved="updateFeatures"></features>
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
  name: "PackagesForm",
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
    packages: {
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
        booking_price: 1,
        booking_price_type: 'fixed',
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
        booking_price: "required",
        booking_price_type: "required",
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
        url = route("admin.packages.store");
      } else {
        url = route("admin.packages.update", this.packages.id);
      }

      axios({
        method: this.mode == "edit" ? "PATCH" : "POST",
        url,
        data: this.data,
      })
        .then((resp) => {
          toastr.success(
            `The package has been ${
              this.mode == "create" ? "created" : "saved"
            }`,
            "Success"
          );
          window.location = route("admin.packages.index");
        })
        .catch((err) => toastr.error(`Unable to ${this.mode} the package`, 'Failed'))
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
    },
    disabledDates(date) {
      const today = moment().startOf('day')
      date = moment(date).startOf('day')

      return date == today || date < today
    }
  },
  computed: {
    oldBaseImage() {
      if (this.mode == "edit" && this.packages) {
        return this.packages.base_image;
      }
    },
    oldAdditionalImages() {
      if (this.mode == "edit" && this.packages) {
        return this.packages.additional_images;
      }
    },
  },
  created() {
    if(this.mode == 'edit' && this.packages && Object.keys(this.packages).length) {
      this.data = {
        name: this.packages.name,
        slug: this.packages.slug,
        description: this.packages.description,
        hours: this.packages.hours,
        price: this.packages.price,
        booking_price: this.packages.booking_price,
        booking_price_type: this.packages.booking_price_type,
        special_price: this.packages.special_price,
        special_price_type: this.packages.special_price_type,
        special_price_start: this.packages.special_price_start,
        special_price_end: this.packages.special_price_end,
        status: this.packages.status,
        base_image: this.packages.base_image ? this.packages.base_image.id : null,
        additional_images: this.packages.additional_images ? this.packages.additional_images.map(image => image.id) : [],
      };
    }
  }
};
</script>

<style>
</style>