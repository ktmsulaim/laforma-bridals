<template>
  <div class="row">
      <div class="col-md-8">
          <div ref="tagsList"></div>
      </div>
      <div class="col-md-4">
          <tag-form @save="refreshTags"></tag-form>
      </div>
  </div>
</template>

<script>

import { Grid, h } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

import TagForm from './TagForm.vue'
export default {
    name: 'ListTags',
    data(){
        return {
            grid: null,
        }
    },
    components: {
        TagForm
    },
    methods: {
        refreshTags() {
            this.$nextTick(() => {
                this.grid.forceRender();
            })
        },
        destroy(id) {
            if(id) {
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
                        axios.delete(route('admin.tags.destroy', id))
                        .then(resp => {
                            this.$swal('The tag has been deleted', '', 'success')
                            this.refreshTags();
                        })
                        .catch(error => {
                            this.$swal('Sorry! Unable to delete the tag', '', 'error')
                        })
                    }
                })
                .catch(error => {
                    this.$swal('Sorry! Unable to delete the tag. Try again later', '', 'error')
                })
            }
        }

    },
    mounted() {
     this.grid = new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Name",
        },
        {
          name: "Slug",
        },
        {
          name: "Created",
        },
        { 
        name: 'Actions',
            formatter: (cell, row) => {
            return h('button', {
                className: 'btn btn-danger btn-sm',
                onClick: () => this.destroy(row.cells[4].data)
            }, `Delete`);
            }
        }
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("admin.tags.list"),
        then: (data) =>
          data.map((item, index) => [
            index + 1,
            item.name,
            item.slug,
            item.created_at,
            item.id,
          ]),
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch tags list.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        summary: false,
      },
    }).render(this.$refs.tagsList);

    // grid.on('cellClick', (...args) => console.log(args));
    // grid.on('rowClick', (...args) => console.log('row: ' + JSON.stringify(args), args));
  },
}
</script>

<style>

</style>