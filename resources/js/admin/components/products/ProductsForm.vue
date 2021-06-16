<template>
  <div>
    <form
      @submit.stop.prevent
      ref="productsCreateForm"
      method="post"
      novalidate
      data-parsley-validate
    >
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
              :class="{'is-invalid': isValid('name')}"
            />
          </div>
          <div class="form-group">
            <label for="description">Description <span class="text-danger">*</span></label>
            <quill-editor
              ref="descriptionEditor"
              v-model="data.description"
              :options="editorOption"
              :class="{'is-invalid': isValid('description')}"
            />   
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="from-group">
                <label for="is_active"
                  >Status <span class="text-danger">*</span></label
                >
                <select v-model="data.is_active" name="is_active" class="form-control" required>
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
                <input type="number" name="price" id="price" min="1" class="form-control" v-model="data.price" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="special_price">Special price</label>
                <input type="number" name="special_price" id="special_price" v-model="data.special_price" min="1" class="form-control">
              </div>
              <div class="col-md-6">
                <label for="special_price_type">Special price type</label>
                <select name="special_price_type" id="special_price_type" v-model="data.special_price_type" class="form-control">
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
                <date-picker value-type="format" input-class="form-control" v-model="data.special_price_start"></date-picker>
              </div>
              <div class="col-md-6">
                <label for="special_price_end">Special price end</label>
                <date-picker value-type="format" input-class="form-control" v-model="data.special_price_end"></date-picker>
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
                <select name="in_stock" id="in_stock" v-model="data.in_stock" class="form-control">
                  <option value="1">In stock</option>
                  <option value="0">Out of stock</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="is_new">Mark as new</label>
                <select name="is_new" id="is_new" v-model="data.is_new" class="form-control">
                  <option value="0">Disable</option>
                  <option value="1">Enable</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div>
                  <label for="new_from">New from</label>
                </div>
                <date-picker value-type="format" input-class="form-control" v-model="data.new_from"></date-picker>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div>
                  <label for="new_from">New to</label>
                </div>
                <date-picker value-type="format" input-class="form-control" v-model="data.new_to"></date-picker>
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
              ></textarea
            >
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="images">
          <div>
            <p>
              <strong>Base image</strong>
            </p>
            <file-manager @selectImage="updateImage" type="base_image"></file-manager>
          </div>
          <hr />
          <div>
            <p>
              <strong>Additional images</strong>
            </p>
            <file-manager @selectImage="updateImage" type="additional_images"></file-manager>
          </div>
        </div>
      </div>
      <div class="mt-2">
        <button type="button" :disabled="hasErrors || loading" @click="submit" class="btn btn-primary">
          <span v-if="loading">
            <i class="mdi mdi-spin mdi-loading"></i> <span class="ml-1">Processing</span>
          </span>
          <span v-else>Save</span>
          
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import FileManager from '../FileManager.vue'

import ErrorsMixin from "../../mixins/errorsMixin";


export default {
  name: "ProductsForm",
  components: {
    DatePicker,
    FileManager
  },
  mixins: [ErrorsMixin],
  data(){
    return {
      loading: false,
      data: {
        name: null,
        description: null,
        is_active: 1,
        price: 1,
        special_price: null,
        special_price_type: 'fixed',
        special_price_start: null,
        special_price_end: null,
        sku: null,
        qty: 1,
        in_stock: 1,
        is_new: 0,
        new_from: null,
        new_to: null,
        meta_title: null,
        meta_description: null,
        base_image: null,
        additional_images: [],
      },
      editorOption:{
        theme: 'snow'
      },
      validations: {
        name: 'required',
        description: 'required',
        status: "required",
        qty: 'required',
        base_image: 'required',
        price: 'required'
      }
    }
  },
  methods: {
    submit() {
      this.validate();

      this.loading = true;

      axios.post(route('admin.products.store'), this.data)
      .then(resp => {
        window.location = route('admin.products.index');
      })
      .catch(err => console.error(err))
      .finally(() => {
        this.loading = false;
      })
    },
    updateImage(value) {
      if(value.type == 'base_image') {
        this.data.base_image = value.id;
      } else if(value.type == 'additional_images') {
        this.data.additional_images = value.ids;
      }
    }
  },
  computed: {
    hasErrors() {
      const errors = this.$store.state.Errors.errors;
      if(errors && Object.keys(errors).length > 0){
        return true;
      }
      return false;
    }
  }
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