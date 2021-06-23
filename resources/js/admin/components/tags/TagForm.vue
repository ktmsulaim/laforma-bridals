<template>
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Add new</h4>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    @input="updateSlug('name', 'slug')"
                    class="form-control"
                    :class="{ 'is-invalid': hasError('name') }"
                    v-model="data.name"
                />
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input
                    type="text"
                    id="slug"
                    class="form-control"
                    :class="{ 'is-invalid': hasError('slug') }"
                    v-slugify
                    v-model="data.slug"
                />
            </div>
            <div class="mt-2">
                <button @click="submit" class="btn btn-primary" :disabled="hasErrors || loading">
                    <span v-if="loading"><span class="mdi mdi-loading mdi-spin"></span></span>
                    <span v-else>Save</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>

import ErrorsMixin from '../../mixins/errorsMixin'
import slugMixin from '../../mixins/slugMixin'
export default {
    name: "TagForm",
    mixins: [ErrorsMixin, slugMixin],
     data() {
         return {
             loading: false,
             data: {
                 name: null,
                 slug: null
             },
             validations: {
                 name: 'required',
                 slug: 'required'
             }
         }
     },
     methods: {
         submit() {
             this.loading = true;

             axios.post(route('admin.tags.store'), this.data)
             .then(resp => {
                 this.$emit('save', true)
                 toastr.success('The tag has been created!', 'Success')
                 this.reset()
             })
             .catch(err => toastr.error('Unable to save the tag. Try again later', 'Error'))
             .finally(() => this.loading = false)

         },
         reset() {
             this.data = {
                 name: null,
                 slug: null
             };
         }
     }
};
</script>

<style></style>
