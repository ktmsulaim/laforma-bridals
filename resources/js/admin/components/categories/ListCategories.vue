<template>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <loading v-if="loading"></loading>
                    <div v-else>
                        <div v-if="categories && categories.length">
                            <categories v-for="(category, index) in categories" :key="index" :category="category"></categories>
                        </div>
                        <p class="text-muted" v-else>No categories found!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <category-form></category-form>
        </div>
    </div>
</template>

<script>
import CategoryForm from "./CategoryForm.vue";
import Loading from '../Loading.vue'
import Categories from './Categories.vue'

export default {
    name: "ListCategories",
    components: {
        CategoryForm,
        Loading,
        Categories
    },
    data() {
        return {
            
        }
    },
    computed: {
        loading() {
            return this.$store.state.Categories.loading;
        },
        categories() {
            return this.$store.state.Categories.all;
        }
    }
};
</script>

<style></style>
