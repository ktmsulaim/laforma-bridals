<template>
  <div v-if="options && options.length">
      <div class="option" v-for="(option, index) in options" :key="index">
        <div class="mb-2">
            <b>{{ option.name }}</b> <span class="text-danger" v-if="option.is_required">*</span>
        </div>
        <div v-if="option.type === 'dropdown'">
            <select class="form-control" v-model="selected[option.name]" @change="updatePrice(option.values.find(value => value.label == selected[option.name]), option)">
                <option :value="value.label" v-for="(value, i) in option.values" :key="i" :disabled="!value.in_stock">{{ value.label }}</option>
            </select>
        </div>
        <div v-else-if="option.type === 'radiobutton'">
            <label v-for="(value,i) in option.values" :for="`value-${value.label}`" :key="i" class="container_radio">
                <input type="radio" v-model="selected[option.name]" :value="value.label" @change="updatePrice(value, option)" :disabled="!value.in_stock" :id="`value-${value.label}`" :name="option.name"> {{ value.label }}
                <span class="checkmark"></span>
            </label>
        </div>
        <div v-else-if="option.type === 'color'">
            <v-swatches v-model="selected[option.name]" @input="getPriceOfColor(option, $event)" :swatches="option.values.filter(color => color.in_stock).map(color => color.label)" inline></v-swatches>
        </div>
    </div>
  </div>
</template>

<script>
import VSwatches from 'vue-swatches'
import 'vue-swatches/dist/vue-swatches.css'
export default {
    name: 'ProductOptions',
    props: ['product'],
    components: {
        VSwatches
    },
    computed: {
        options() {
            if(this.product.options.has_options) {
                return this.product.options.items;
            }
        },
        totalSpecialPrice() {
            let price = this.specialPrice;

            if(price > 0) {
                Object.entries(this.total).forEach((item, index) => {
                    if(item[0] != 'price') {
                        price += item[1];
                    }
                })
            }
            
            
            return price;

        },
        totalPrice() {
            let price = 0;
            
            Object.entries(this.total).forEach((item, index) => price += item[1])
            
            return price;

        }
    },
    data() {
        return {
            selected: {
                ...this.product.options.items.reduce((result, item, index, array) => {
                    result[item.name] = null;
                    return result;
                }, {})
            },
            total:{
                price: this.product.price.original,
                ...this.product.options.items.reduce((result, item, index, array) => {
                    result[item.name] = 0;
                    return result;
                }, {}),
            },
            specialPrice: this.product.special_price.original
        }
    }, 
    methods: {
        getPriceOfColor(option, color) {
            if(option && color) {
                const colorObj = option.values.find(value => value.label === color);
                
                if(colorObj) {
                    this.updatePrice(colorObj, option);
                }
            }
        },
        updatePrice(value, option = null) {
            if(this.options && this.options.length) {
                if(option){
                    this.total[option.name] = value.price.net_price;
                    this.$emit('updateOptions', this.selected)
                }
                this.$emit('updatePrice', {price: this.totalPrice, special_price: this.totalSpecialPrice})
            }
        }
    },
}
</script>

<style>

</style>