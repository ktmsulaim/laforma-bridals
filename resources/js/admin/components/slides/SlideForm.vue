<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label for="title">Title</label>
            <input
              type="text"
              id="title"
              class="form-control"
              v-model="data.title"
              :class="{ 'is-invalid': hasError('title') }"
            />
          </div>
          <div class="form-group">
            <label for="sub_title">Sub title</label>
            <input
              type="text"
              id="sub_title"
              class="form-control"
              v-model="data.sub_title"
              :class="{ 'is-invalid': hasError('sub_title') }"
            />
          </div>

          <div class="row form-group">
            <div class="col-md-6">
              <label for="overlay">Overlay</label>
              <select id="overlay" class="form-control" v-model="data.overlay">
                <option value="">None</option>
                <option value="light">Light</option>
                <option value="dark">Dark</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="text_direction">Text direction</label>
              <select
                id="text_direction"
                class="form-control"
                v-model="data.text_direction"
              >
                <option value="">None</option>
                <option value="left">Left</option>
                <option value="center">Center</option>
                <option value="right">Right</option>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-6">
              <label for="action_button_link">Action button link</label>
              <input
                type="url"
                id="action_button_link"
                class="form-control"
                v-model="data.action_button_link"
                :class="{ 'is-invalid': hasError('action_button_link') }"
              />
            </div>
            <div class="col-md-6">
              <label for="action_button_text">Action button text</label>
              <input
                type="text"
                id="action_button_text"
                class="form-control"
                v-model="data.action_button_text"
                :class="{ 'is-invalid': hasError('action_button_text') }"
              />
            </div>
          </div>
          <div class="form-group">
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
      <Errors />
      <div class="card">
        <div class="card-header">
          <h4 class="m-0">Base image (1450x750)</h4>
        </div>
        <div class="card-body">
          <file-manager
            :oldBaseImage="oldBaseImage"
            @selectImage="updateImage"
            type="base_image"
          ></file-manager>
        </div>
      </div>
      <div class="card" v-if="mode === 'edit' && slide.id">
          <div class="card-header">
              <h4 class="m-0 text-danger">Delete slide</h4>
          </div>
          <div class="card-body">
              <button :disabled="destroyLoading" @click="destroy" class="btn btn-danger">
                  <span v-if="destroyLoading">
                      <i class="mdi mdi-spin mdi-loading"></i>
                      <span>Processing</span>
                  </span>
                  <span v-else>
                      Delete
                  </span>
              </button>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import ErrorsMixin from "../../mixins/errorsMixin";
import Errors from "../Errors.vue";
export default {
  name: "SlideForm",
  mixins: [ErrorsMixin],
  components: {
    Errors,
  },
  props: {
    mode: {
      type: String,
      required: true,
      default: "create",
    },
    slide: {
        type: Object,
        required: false,
    }
  },
  data() {
    return {
      loading: false,
      destroyLoading: false,
      data: {
        title: null,
        sub_title: null,
        overlay: null,
        text_direction: null,
        action_button_link: null,
        action_button_text: null,
        status: 1,
        base_image: null,
      },
      validations: {
        base_image: "required",
      },
    };
  },
  computed: {
      oldBaseImage() {
          if(this.mode == 'edit' && this.slide) {
              return this.slide.base_image;
          }
      }
  },
  methods: {
      updateImage(val) {
          this.data.base_image = val.id;
      },
      submit(){
          this.loading = true;
            let method, url;
        if(this.mode === 'create') {
            method = 'POST';
            url = route('admin.slides.store');
        } else if(this.mode === 'edit') {
            method = 'PATCH';
            url = route('admin.slides.update', {slide: this.slide.id})
        }
          
        axios({
            method,
            url,
            data: this.data
        })
        .then(resp => {
            toastr.success(`The slide has been ${this.mode === 'create' ? 'created' : 'saved'}`, 'Success')

            window.location = route('admin.slides.index')
        })
        .catch(err => {
            toastr.error(`Unable to ${this.mode === 'create' ? 'create' : 'save'} the slide`, 'Error')
        })
        .finally(() => this.loading = false)
      },
      destroy() {
          this.destroyLoading = true;
          if(this.mode === 'edit' && this.slide.id) {
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
                    axios.delete(route('admin.slides.destroy', this.slide.id))
                    .then(resp => {
                        this.$swal('The slide has been deleted', '', 'success')
                        window.location = route('admin.slides.index')
                    })
                    .catch(error => {
                        this.$swal('Sorry! Unable to delete the slide', '', 'error')
                    })
                }
            })
            .catch(error => {
                this.$swal('Sorry! Unable to delete the slide. Try again later', '', 'error')
            })
          }
      }
  },
  created() {
      if(this.mode === 'edit' && this.slide) {
          this.data.title = this.slide.title
          this.data.sub_title = this.slide.sub_title
          this.data.overlay = this.slide.overlay
          this.data.text_direction = this.slide.text_direction
          this.data.action_button_link = this.slide.action_button_link
          this.data.action_button_text = this.slide.action_button_text
          this.data.status = this.slide.status
      }
  }
};
</script>

<style>
</style>