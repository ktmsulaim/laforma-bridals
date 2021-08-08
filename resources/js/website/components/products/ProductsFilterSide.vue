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
              <input type="checkbox" name="category" :value="category.id" v-model="filter.categories" />
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
              >Orderable
              <input type="checkbox" name="tag" v-model="filter.attributes.orderable" />
              <span class="checkmark"></span>
            </label>
          </li>
          <li>
            <label class="container_check"
              >In stock
              <input type="checkbox" name="tag" v-model="filter.attributes.in_stock" />
              <span class="checkmark"></span>
            </label>
          </li>
          <li>
            <label class="container_check"
              >New arrival
              <input type="checkbox" name="tag" v-model="filter.attributes.is_new" />
              <span class="checkmark"></span>
            </label>
          </li>
          <li>
            <label class="container_check"
              >Offer price
              <input type="checkbox" name="tag" v-model="filter.attributes.has_offer" />
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
                categories: [],
                tags: [],
                price: {
                  min: 0,
                  max: 0
                },
                attributes: {
                  orderable: 0,
                  in_stock: 0,
                  is_new: 0,
                  has_offer: 0
                }
            }
        }
    },
    methods: {
        resetFilter() {
            this.filter.categories = [];
            this.filter.tags = [];
            this.filter.price = {min: 0, max: this.maxPrice ? this.maxPrice : 100}
            this.filter.attributes = {
              orderable: 0,
              in_stock: 0,
              is_new: 0,
              has_offer: 0
            }

            //clear current url
            window.history.replaceState({}, document.title, route('products.index'))
            this.$store.commit('clearFilter')
            this.$emit('updateFilter')
        },
        applyFilter() {
            this.$store.commit('applyFilter', {
                categories: JSON.stringify(this.filter.categories),
                tags: JSON.stringify(this.filter.tags),
                price: JSON.stringify({min: this.filter.price.min, max: this.filter.price.max}),
                attributes: JSON.stringify(this.filter.attributes)
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
            'tags': 'getTags',
            'filters': 'getFilters'
        }),
        hasFilter() {
            if((this.filter.categories && this.filter.categories.length) || 
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

      if(this.filters) {
        if(!_.isEmpty(this.filters.categories)) {
          this.filter.categories = JSON.parse(this.filters.categories)
        }

        if(!_.isEmpty(this.filters.tags)) {
          this.filter.tags = JSON.parse(this.filters.tags)
        }
      }
    }
};
</script>

<style>
</style>