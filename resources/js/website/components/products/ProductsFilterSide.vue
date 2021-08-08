<template>
  <div class="filter_col">
    <div class="inner_bt">
      <a href="#" class="open_filters"><i class="ti-close"></i></a>
    </div>
    <div class="filter_type version_2" v-if="categories && categories.length">
      <h4>
        <a href="#filter_1" data-toggle="collapse" class="opened">Categories</a>
      </h4>
      <div class="collapse show" id="filter_1">
        <ul>
          <li v-for="category in categories" :key="category.id">
            <label class="container_check"
              >{{ category.name }} <small>{{ category.products }}</small>
              <input type="checkbox" name="category" :value="category.id" v-model="filter.category" />
              <span class="checkmark"></span>
            </label>
          </li>
        </ul>
      </div>
      <!-- /filter_type -->
    </div>

    <div class="filter_type version_2" v-if="tags && tags.length">
      <h4>
        <a href="#filter_2" data-toggle="collapse" class="opened">Tags</a>
      </h4>
      <div class="collapse show" id="filter_2">
        <ul>
          <li v-for="tag in tags" :key="tag.id">
            <label class="container_check"
              >{{ tag.name }} <small>{{ tag.products }}</small>
              <input type="checkbox" name="tag" :value="tag.id" v-model="filter.tags" />
              <span class="checkmark"></span>
            </label>
          </li>
        </ul>
      </div>
      <!-- /filter_type -->
    </div>
    
    <div class="filter_type version_2">
      <h4>
        <a href="#filter_3" data-toggle="collapse" class="opened">Attributes</a>
      </h4>
      <div class="collapse show" id="filter_3">
        <ul>
          <li>
            <label class="container_check"
              >Orderable <small>0</small>
              <input type="checkbox" name="tag" v-model="filter.attributes.orderable" />
              <span class="checkmark"></span>
            </label>
          </li>
        </ul>
      </div>
      <!-- /filter_type -->
    </div>

    <div class="filter_type version_2">
      <h4>
        <a href="#filter_4" data-toggle="collapse" class="opened">Price</a>
      </h4>
      <div class="collapse show" id="filter_4">
        <div class="row form-group">
          <div class="col">
            <label for="min">Min</label>
            <input type="number" id="min" class="form-control" min="0" @input="checkPrice('min')" v-model="filter.price.min">
          </div>
          <div class="col">
            <label for="max">Max</label>
            <input type="number" id="max" class="form-control" min="0" @input="checkPrice('max')" v-model="filter.price.max">
          </div>
        </div>
      </div>
    </div>
    <!-- /filter_type -->
    <div class="buttons">
      <button @click="applyFilter" :disabled="loading || !hasFilter" class="btn_1">Filter</button>
      <button @click="resetFilter" :disabled="loading || !hasFilter" class="btn_1 gray">Reset</button>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    name: 'ProductsFilterSide',
    props: ['maxPrice'],
    data() {
        return {
            filter: {
                category: [],
                tags: [],
                price: {
                  min: 0,
                  max: 0
                },
                attributes: {
                  orderable: 1,
                }
            }
        }
    },
    methods: {
        resetFilter() {
            this.filter.category = [];
            this.filter.tags = [];

            this.$store.commit('clearFilter')
            this.$emit('updateFilter')
        },
        applyFilter() {
            this.$store.commit('applyFilter', {
                categories: JSON.stringify(this.filter.category),
                tags: JSON.stringify(this.filter.tags),
                price: JSON.stringify({min: this.filter.price.min, max: this.filter.price.max})
            })

            this.$emit('updateFilter')
        },
        checkPrice(type) {
          let value = this.filter.price[type]

          if(value < 0) {
            this.filter.price[type] = 0
          } else if(this.maxPrice && value > this.maxPrice) {
            this.filter.price[type] = this.maxPrice;
          }
        }
    },
    computed: {
        ...mapGetters({
            'loading': 'getLoading',
            'categories': 'getCategories',
            'tags': 'getTags'
        }),
        hasFilter() {
            if((this.filter.category && this.filter.category.length) || 
            (this.filter.tags && this.filter.tags.length) ||
            this.filter.price)
            {
                return true;
            }

            return false;
        }
    },
    created() {
      if(this.maxPrice) {
        this.filter.price.max = this.maxPrice;
      }
    }
};
</script>

<style>
</style>