<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input
              type="text"
              id="title"
              class="form-control"
              @input="updateSlug('title', 'slug')"
              v-model="data.title"
              :class="{ 'is-invalid': hasError('title') }"
            />
          </div>

          <div class="form-group">
            <label for="slug">Slug <span class="text-danger">*</span></label>
            <input
              type="text"
              id="slug"
              class="form-control"
              v-model="data.slug"
              :class="{ 'is-invalid': hasError('slug') }"
            />
          </div>

          <div class="form-group">
            <label for="description">Content</label>
            <quill-editor
              ref="descriptionEditor"
              v-model="data.content"
              :options="editorOption"
              :class="{ 'is-invalid': hasError('content') }"
            />
          </div>

          <div class="row form-group">
            <div class="col-md-6">
              <label for="column_size">Column Size</label>
              <select
                id="column_size"
                v-model="data.layout.column_size"
                class="form-control"
              >
                <option value="12">Full width</option>
                <option value="6">Half width</option>
                <option value="4">Quarter width</option>
                <option value="3">One third width</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="algin">Align</label>
              <select
                id="algin"
                v-model="data.layout.align"
                class="form-control"
              >
                <option value="start">Left</option>
                <option value="center">Center</option>
                <option value="end">Right</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <div class="custom-control custom-switch">
                  <input
                    type="checkbox"
                    id="status"
                    class="custom-control-input"
                    v-model="data.status"
                  />
                  <label for="status" class="custom-control-label"
                    >Enable</label
                  >
                </div>
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
    </div>
    <div class="col-md-4">
      <errors></errors>

      <div class="card" v-if="mode === 'edit' && page.id">
        <div class="card-header">
          <h4 class="m-0 text-danger">Delete page</h4>
        </div>
        <div class="card-body">
          <p>Want to delete this page?</p>
          <button
            :disabled="destroyLoading"
            @click="destroy"
            class="btn btn-danger"
          >
            <span v-if="destroyLoading">
              <i class="mdi mdi-spin mdi-loading"></i>
              <span>Processing</span>
            </span>
            <span v-else> Delete </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ErrorsMixin from "../../mixins/errorsMixin";
import slugMixin from "../../mixins/slugMixin";

import Errors from "../Errors.vue";
export default {
  name: "PageForm",
  props: {
    mode: {
      type: String,
      required: true,
      default: "create",
    },
    page: {
      type: Object,
      required: false,
    },
  },
  mixins: [ErrorsMixin, slugMixin],
  components: {
    Errors,
  },
  data() {
    return {
      loading: false,
      destroyLoading: false,
      data: {
        title: null,
        slug: null,
        content: null,
        layout: {
          column_size: 12,
          align: "center",
        },
        status: 1,
      },
      validations: {
        title: "required",
        slug: "required",
      },
      editorOption: {
        theme: "snow",
      },
    };
  },
  methods: {
    submit() {
      this.loading = true;
      let method, url;

      if (this.mode === "create") {
        method = "POST";
        url = route("admin.pages.store");
      } else {
        method = "PATCH";
        url = route("admin.pages.update", this.page.id);
      }

      axios({
        method,
        url,
        data: this.data,
      })
        .then((resp) => {
          toastr.success(
            `The page has been ${
              this.mode === "create" ? "created" : "saved"
            }!`,
            "Success"
          );
          window.location = route("admin.pages.index");
        })
        .catch((err) => {
          toastr.error(
            `Unable to ${this.mode === "create" ? "create" : "save"} the page`,
            "Error"
          );
        })
        .finally(() => (this.loading = false));
    },
    destroy() {
      if (this.mode === "edit" && this.page && this.page.id) {
        this.destroyLoading = true;

        this.$swal({
          titleText: "Are you sure?",
          icon: "warning",
          allowOutsideClick: false,
          showCancelButton: true,
          confirmButtonText: "Proceed",
          confirmButtonColor: "#ff5b5b",
        })
          .then((result) => {
            if (result.isConfirmed) {
              axios
                .delete(route("admin.pages.destroy", this.page.id))
                .then((resp) => {
                  this.$swal("The page has been deleted", "", "success");
                  window.location = route("admin.pages.index");
                })
                .catch((error) => {
                  this.$swal("Sorry! Unable to delete the page", "", "error");
                });
            }
          })
          .catch((error) => {
            this.$swal(
              "Sorry! Unable to delete the page. Try again later",
              "",
              "error"
            );
          });
      }
    },
  },
  created() {
    if (this.mode === "edit" && this.page) {
      this.data.title = this.page.title;
      this.data.slug = this.page.slug;
      this.data.content = this.page.content;
      this.data.layout.column_size = this.page.layout.column_size;
      this.data.layout.align = this.page.layout.align;
      this.data.status = this.page.status;
    }
  },
};
</script>

<style>
</style>