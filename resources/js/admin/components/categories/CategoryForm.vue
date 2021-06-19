<template>
  <div class="card">
      <div class="card-header">
          <h4 class="card-title m-0">
              <span v-if="edit.status">Edit <span v-if="data.name">{{ data.name }}</span></span>
              <span v-else>Add new</span>
          </h4>
      </div>
      <div class="card-body">
          <form @submit.prevent="submit" ref="categoryForm">
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" id="name" @input="updateSlug" class="form-control" :class="{'is-invalid': hasError('name')}" v-model="data.name">
              </div>
              <div class="form-group">
                  <label for="slug">Slug</label>
                  <input type="text" id="slug" class="form-control" :class="{'is-invalid': hasError('slug')}" v-slugify v-model="data.slug">
              </div>
              <div class="form-group">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" v-model="data.show_in_nav" id="show_in_nav">
                                <label class="custom-control-label" for="show_in_nav">Show in menu</label>
                            </div>
                      </div>
                      <div class="col-md-6">
                          <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" v-model="data.is_orderable" id="is_orderable">
                                <label class="custom-control-label" for="is_orderable">Saleable</label>
                            </div>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                      <div class="col-md-6">
                      <label for="mode">Mode</label>
                      <select name="mode" id="mode" class="form-control" @change="trackParent" v-model="mode">
                          <option value="1">Main</option>
                          <option value="2">Sub</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label for="parent">Parent</label>
                      <select2 v-model="data.parent" :options="categoryOptions" :settings="{placeholder: 'Select a parent category', width: '100%', disabled: isParent }" :disabled="isParent"></select2>
                  </div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="status-select">Status</label>
                  <select name="status" id="status-select" class="form-control" v-model="data.status">
                      <option value="1">Enabled</option>
                      <option value="0">Disabled</option>
                  </select>
              </div>
            <div>
                <button @click="submit" class="btn btn-primary" :disabled="hasErrors || loading">
                    <span v-if="loading"><span class="mdi mdi-loading mdi-spin"></span></span>
                    <span v-else>Save</span>
                </button>
                <button type="button" v-if="edit.status" class="btn btn-secondary ml-2" @click="cancelEdit">Cancel</button>
            </div>
          </form>
      </div>
  </div>
</template>

<script>
import ErrorsMixin from '../../mixins/errorsMixin'
import { mapGetters } from 'vuex'
import Select2 from 'v-select2-component'

export default {
    name: 'CategoryForm',
    mixins: [ErrorsMixin],
    components: {
        Select2
    },
    data() {
        return {
            loading: false,
            mode: 1,
            data: {
                name: null,
                slug: null,
                parent: null,
                show_in_nav: 1,
                is_orderable: 1,
                status: 1,
            },
            validations: {
                name: 'required',
                slug: 'required'
            },
            edit: {
                status: false,
                id: null,
                oldParent: null,
            },
        }
    },
    methods: {
        submit(){
            this.loading = true;
            let url, method;

            if(this.edit.status) {
                if(!this.edit.id) {
                    return;
                }

                url = route('admin.categories.update', this.edit.id)
                method = 'PATCH';
            } else {
                url = route('admin.categories.store');
                method = 'POST';
            }

            axios({
                url,
                method,
                data: this.data
            })
            .then(resp => {
                if(this.edit.status) {
                    this.cancelEdit()
                } else {
                    this.reset();
                }

                this.$store.dispatch('fetchCategories');

                const type = this.edit.status ? 'updated' : 'added';
                toastr.success(`The category has been ${type}`, 'Success')
            })
            .catch(err => {
                const type = this.edit.status ? 'update' : 'add';
                toastr.error(`Unable to ${type} the category!`)
                console.error(err)
            })
            .finally(() => {
                this.loading = false;
                this.edit.status = false;
                this.edit.id = null;
            })
        },
        editMode(category) {
            if(typeof category != 'object') {
                this.cancelEdit();
                return;
            }

            this.edit.status = true;
            this.edit.id = category.id;

            this.data.name = category.name;
            this.data.slug = category.slug;
            this.data.show_in_nav = category.show_in_nav;
            this.data.is_orderable = category.is_orderable;
            this.data.status = category.status;
            this.data.parent = category.parent;

            this.mode = category.parent ? 2 : 1;
        },
        updateSlug() {
            if(this.data.name) {
                this.data.slug = this.slugify(this.data.name);
            } else {
                this.data.slug = this.data.name;
            }
        },
        reset() {
            this.data = {
                name: null,
                slug: null,
                parent: null,
                show_in_nav: 1,
                is_orderable: 1,
                status: 1,
            };
        },
        cancelEdit() {
            this.$store.commit('select', null)

            this.edit.status = false;
            this.edit.id = null;
            this.edit.oldParent = null;

            this.reset();
        },
        trackParent() {
            if(this.edit.status) {
                if(this.selected && this.selected.parent) {
                    if(this.mode == 1) {
                        this.edit.oldParent = this.selected.parent;
                        this.data.parent = null;
                    } else {
                        this.data.parent = this.edit.oldParent;
                    }
                }
            }
            
        }
    },
    computed: {
        ...mapGetters(
            {
                'categorySelectOptions': 'getForSelect',
                'selected': 'getSelected',
            }
        ),
        categoryOptions() {
            if(this.categorySelectOptions) {
                return this.categorySelectOptions.map(item => {
                    return {
                        id: item.id,
                        text: item.text
                    };
                })
            }
        },
        isParent() {
            return this.mode == 1;
        }
    },
    watch: {
        selected(oldVal, newVal) {
            if(oldVal) {
                this.editMode(oldVal);
            }
        }
    },
    created() {
        this.$store.dispatch('fetchCategories');
    }
}
</script>

<style>

</style>