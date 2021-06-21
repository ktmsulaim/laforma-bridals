<template>
  <div>
    <form @submit.stop.prevent method="post" novalidate data-parsley-validate>
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
            href="#other"
            data-toggle="tab"
            aria-expanded="false"
            class="nav-link"
          >
            <span class="d-block d-sm-none"
              ><i class="far fa-envelope"></i
            ></span>
            <span class="d-none d-sm-block">Other</span>
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
              :class="{ 'is-invalid': hasError('name') }"
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
          <div class="row">
            <div class="col-md-6">
              <div class="from-group">
                <label for="category_id"
                  >Category <span class="text-danger">*</span></label
                >
                <select2
                  v-model="data.category_id"
                  :options="categoryOptions"
                  :settings="{
                    placeholder: 'Select a category',
                    width: '100%',
                  }"
                ></select2>
              </div>
            </div>
            <div class="col-md-6">
              <tags :product="product" @select="updateTags"></tags>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-6">
              <div class="from-group">
                <label for="is_active"
                  >Status <span class="text-danger">*</span></label
                >
                <select
                  v-model="data.is_active"
                  name="is_active"
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
        <div role="tabpanel" class="tab-pane fade" id="other">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="sku">SKU</label>
                <input
                  type="text"
                  class="form-control"
                  name="sku"
                  v-model="data.sku"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="qty">Quantity</label>
                <input
                  type="number"
                  name="qty"
                  id="qty"
                  min="1"
                  class="form-control"
                  v-model="data.qty"
                />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="in_stock">Stock availability</label>
                <select
                  name="in_stock"
                  id="in_stock"
                  v-model="data.in_stock"
                  class="form-control"
                >
                  <option value="1">In stock</option>
                  <option value="0">Out of stock</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input
                    type="checkbox"
                    id="track_stock"
                    class="custom-control-input"
                    v-model="data.track_stock"
                  />
                  <label for="track_stock" class="custom-control-label"
                    >Track stock</label
                  >
                </div>
              </div>
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div>
                  <label for="new_from">New from</label>
                </div>
                <date-picker
                  value-type="format"
                  input-class="form-control"
                  v-model="data.new_from"
                ></date-picker>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div>
                  <label for="new_from">New to</label>
                </div>
                <date-picker
                  value-type="format"
                  input-class="form-control"
                  v-model="data.new_to"
                ></date-picker>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="is_new">Mark as new</label>
                <select
                  name="is_new"
                  id="is_new"
                  v-model="data.is_new"
                  class="form-control"
                >
                  <option value="0">Disable</option>
                  <option value="1">Enable</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="meta_title">Meta title</label>
            <input
              type="text"
              name="meta_title"
              class="form-control"
              v-model="data.meta_title"
            />
          </div>
          <div class="form-group">
            <label for="meta_description">Meta description</label>
            <textarea
              id="meta_description"
              name="meta_description"
              rows="5"
              class="form-control"
              v-model="data.meta_description"
            ></textarea>
          </div>
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
    </form>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import Select2 from "v-select2-component";
import { mapGetters } from "vuex";

import FileManager from "../FileManager.vue";
import Tags from "./Tags.vue";

import ErrorsMixin from "../../mixins/errorsMixin";

export default {
  name: "ProductsForm",
  components: {
    DatePicker,
    Select2,
    FileManager,
    Tags,
  },
  mixins: [ErrorsMixin],
  props: {
    mode: {
      type: String,
      required: true,
      default: "create",
    },
    product: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      loading: false,
      data: {
        category_id: null,
        tags: null,
        name: null,
        description: null,
        is_active: 1,
        price: 1,
        special_price: null,
        special_price_type: "fixed",
        special_price_start: null,
        special_price_end: null,
        sku: null,
        qty: 1,
        in_stock: 1,
        track_stock: true,
        is_new: 0,
        new_from: null,
        new_to: null,
        meta_title: null,
        meta_description: null,
        base_image: null,
        additional_images: [],
      },
      editorOption: {
        theme: "snow",
      },
      validations: {
        category_id: "required",
        name: "required",
        description: "required",
        is_active: "required",
        qty: "required",
        base_image: this.mode == "create" ? "required" : "",
        price: "required",
      },
    };
  },
  methods: {
    submit() {
      this.validate();

      this.loading = true;
      let url;

      if (this.mode == "create") {
        url = route("admin.products.store");
      } else {
        url = route("admin.products.update", this.product.id);
      }

      axios({
        method: this.mode == "edit" ? "PATCH" : "POST",
        url,
        data: this.data,
      })
        .then((resp) => {
          toastr.success(
            `The product has been ${
              this.mode == "create" ? "created" : "saved"
            }`,
            "Success"
          );
          window.location = route("admin.products.index");
        })
        .catch((err) => console.error(err))
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
    updateTags(val) {
      this.data.tags = val;
    }
  },
  computed: {
    ...mapGetters({
      categorySelectOptions: "getForSelect",
    }),
    categoryOptions() {
      if (this.categorySelectOptions) {
        return this.categorySelectOptions.map((item) => {
          return {
            id: item.id,
            text: item.text,
          };
        });
      }
    },
    tagsList() {
      return [
        {
          id: 1,
          text: "One",
        },
      ];
    },
    oldBaseImage() {
      if (this.mode == "edit" && this.product) {
        return this.product.base_image;
      }
    },
    oldAdditionalImages() {
      if (this.mode == "edit" && this.product) {
        return this.product.additional_images;
      }
    },
  },
  created() {
    this.$store.dispatch("fetchCategories");
    if (
      this.mode == "edit" &&
      this.product &&
      Object.keys(this.product).length
    ) {
      this.data.name = this.product.name;
      this.data.category_id = this.product.category_id;
      this.data.description = this.product.description;
      this.data.is_active = this.product.is_active;
      this.data.price = this.product.price;
      this.data.special_price = this.product.special_price;
      this.data.special_price_type = this.product.special_price_type;
      this.data.special_price_start = this.product.special_price_start;
      this.data.special_price_end = this.product.special_price_end;
      this.data.in_stock = this.product.in_stock;
      this.data.track_stock = this.product.track_stock;
      this.data.sku = this.product.sku;
      this.data.qty = this.product.qty;
      this.data.is_new = this.product.is_new;
      this.data.new_from = this.product.new_from;
      this.data.new_to = this.product.new_to;
      this.data.meta_title = this.product.meta_title;
      this.data.meta_description = this.product.meta_description;

      this.data.base_image = this.product.base_image
        ? this.product.base_image.id
        : null;
      this.data.additional_images = this.product.additional_images
        ? this.product.additional_images.map((image) => image.id)
        : null;
    }
  },
};
</script>

<style>
.mx-datepicker {
  display: block;
  width: 100%;
}
.ql-editor {
  min-height: 200px;
}
</style>
