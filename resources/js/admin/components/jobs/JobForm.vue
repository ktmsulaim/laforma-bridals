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

          <div class="form-group">
              <div class="row">
                  <div class="col-md-6">
                      <label for="for">For <span class="text-danger">*</span></label>
                      <select id="for" class="form-control" v-model="data.for">
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                       <label for="type">Type <span class="text-danger">*</span></label>
                      <select id="type" class="form-control" v-model="data.type">
                          <option value="fulltime">Full time</option>
                          <option value="parttime">Part time</option>
                      </select>
                  </div>
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
      <div class="card">
        <div class="card-header">
          <h4 class="m-0">Base image</h4>
        </div>
        <div class="card-body">
          <file-manager
            :oldBaseImage="oldBaseImage"
            @selectImage="updateImage"
            type="base_image"
          ></file-manager>
        </div>
      </div>
      <slot />
    </div>
  </div>
</template>

<script>
import ErrorsMixin from "../../mixins/errorsMixin";
import slugMixin from "../../mixins/slugMixin";
export default {
  name: "JobForm",
  props: {
    mode: {
      type: String,
      required: true,
      default: "create",
    },
    job: {
      type: Object,
      required: false,
    },
  },
  mixins: [ErrorsMixin, slugMixin],
  data() {
    return {
    loading: false,
      data: {
        title: null,
        slug: null,
        description: null,
        for: 'male',
        type: 'fulltime',
        status: true,
        base_image: null,
      },
      validations: {
        title: "required",
        slug: "required",
        description: "required",
        for: "required",
        type: "required",
        status: 1,
        base_image: "required",
      },
      editorOption: {
        theme: "snow",
      },
    };
  },
  computed: {
      oldBaseImage() {
          if(this.mode == 'edit' && this.job) {
              return this.job.base_image;
          }
      }
  },
  methods: {
      submit() {
          let url, method;
          
          this.loading = true;
          
          if(this.mode == 'create') {
              url = route('admin.jobs.store');
              method = 'POST';
          } else if (this.mode == 'edit') {
              url = route('admin.jobs.update', this.job.id)
              method = 'PATCH';
          }

          axios({
              url,
              method,
              data: this.data
          })
          .then(resp => {
              toastr.success(`The job has been ${this.mode}d`, 'Success')
              window.location = route('admin.jobs.index')
          })
          .catch(err => toastr.error(`Unable to ${this.mode} the job.`, 'Failed'))
          .finally(() => this.loading = false)

      },
      updateImage(val) {
          this.data.base_image = val.id;
      }
  },
  created() {
      if(this.mode == 'edit' && this.job && Object.keys(this.job).length) {
          this.data = {
            title: this.job.title,
            slug: this.job.slug,
            description: this.job.description,
            for: this.job.for,
            type: this.job.type,
            status: this.job.status,
            base_image: this.job.base_image ? this.job.base_image.id : null,
          };
      }
  }
};
</script>

<style>
</style>