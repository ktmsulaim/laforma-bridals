<template>
  <div class="toolbox elemento_stick">
    <div class="container">
        <ul class="clearfix">
            <li>
                <div class="sort_select">
                    <select name="sort" id="sort" :disabled="loading" v-model="sort" @change="changeSort">
                        <option value="date">Sort by newness</option>
                        <option value="popularity">Sort by popularity</option>
                        <option value="price">Sort by price: low to high</option>
                        <option value="price-desc">Sort by price: high to low</option>
                    </select>
                </div>
            </li>
            <li>
                <span @click="changeViewMode('grid')" class="product-view-mode" :class="{'active': mode === 'grid'}"><i class="ti-view-grid"></i></span>
                <span @click="changeViewMode('list')" class="product-view-mode" :class="{'active': mode === 'list'}"><i class="ti-view-list"></i></span>
            </li>
            <li>
                <a href="#0" class="open_filters">
                    <i class="ti-filter"></i><span>Filters</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /toolbox -->
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: 'ProductsToolBox',
    data() {
        return {
            sort: 'date',
        }
    },
    computed: {
        ...mapGetters({
            'loading': 'getLoading',
            'mode': 'getMode',
        }),
    },
    methods: {
        changeViewMode(mode) {
            if(mode) {
                this.$store.commit('setMode', mode);
            }
        },
        changeSort() {
            this.$store.commit('setSort', this.sort)
        }
    },
    mounted() {
        this.$store.commit('setSort', this.sort)
    }
}
</script>

<style>

</style>