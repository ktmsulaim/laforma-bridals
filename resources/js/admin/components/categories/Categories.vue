<template>
  <div class="category-item" :class="{'child-depth': isChild}">
      <div class="content" :class="{'selected bg-primary text-white': isSelected, 'is-child': isChild, 'border': isParent}">
          <h4 class="title">{{ category.name }}</h4>
          <div class="meta">
              <div>
                  <span class="status"><b>Status: </b>
                    <span class="badge badge-success" v-if="category.status">Enabled</span>
                    <span class="badge badge-danger" v-else>Disabled</span>
                  </span>
                  <span class="ml-4"><b>Show in menu: </b>
                    <span>{{ category.show_in_nav == 1 ? 'Yes' : 'No' }}</span>
                  </span>
                  <span class="ml-4"><b>Saleable: </b>
                    <span>{{ category.is_orderable == 1 ? 'Yes' : 'No' }}</span>
                  </span>
              </div>
              <div class="actions">
                  <span @click="select(category)" class="mdi mdi-pencil-box-outline action-btn"></span>
                  <span @click="confirmDelete(category)" class="mdi mdi-delete-outline action-btn"></span>
              </div>
          </div>
      </div>
      <category-item :category="category"></category-item>
  </div>
</template>

<script>

export default {
    name: 'Categories',
    props: ['category'],
    data() {
        return {
            destroy: {
                item: null,
            }
        }
    },
    computed:{
        isChild() {
            return this.category.parent != null;
        },
        isParent() {
            return this.category.parent == null;
        },
        isSelected() {
            const selected = this.$store.state.Categories.selected;
            return selected && selected.id == this.category.id;
        }
    },
    methods: {
        select(category) {
            this.$store.commit('select', category);
        },
        confirmDelete(category) {
            if(category) {
                this.destroy.item = category;

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
                        axios.delete(route('admin.categories.destroy', category.id))
                        .then(resp => {
                            this.$swal('The category has been deleted', '', 'success')
                            this.$store.dispatch('fetchCategories');
                        })
                        .catch(error => {
                            this.$swal('Sorry! Unable to delete the category', '', 'error')
                        })
                    }
                })
                .catch(error => {
                    this.$swal('Sorry! Unable to delete the category', '', 'error')
                })
            }
        }
    },
    beforeCreate() {
        this.$options.components.CategoryItem = require('./CategoryItem.vue').default
    }
}
</script>

<style scoped>
.child-depth {
    padding-left: 25px;
    margin-left: 10px;
    box-shadow: none;
}
.is-child {
    border-left: 2px dotted #e1e1e1;
    padding-left: 15px;
    border-radius: 0;
    position: relative;
}

.is-child::before {
    position: absolute;
    content: "";
    height: 2px;
    border-top: 2px dotted #e1e1e1;
    top: 50%;
    left: 0;
    width: 15px;
}

.selected .card-title {
    color: #fff;
}

.selected .actions .mdi {
    color: #fff;
}
</style>