<template>
    <div class="filters">
        <i class="mdi mdi-filter-outline icon"></i>
      
      <span @click="select(index)" v-for="(filter, index) in filters" :key="index" class="filter-item" :class="{active: isSelected(index)}">
        <span>{{ filter.name }}</span>
        <i v-if="isSelected(index)" class="mdi mdi-close"></i>
      </span>
    </div>
</template>

<script>
export default {
    name: 'Filters',
    data() {
        return {
            selected: 0,
            filters: [
                {
                    name: 'Booked',
                    value: 'full_amount_pending',
                },
                {
                    name: 'Pending',
                    value: 'pending',
                },
                {
                    name: 'Booking Charge Pending',
                    value: 'booking_charge_pending',
                },
                {
                    name: 'On Hold',
                    value: 'on_hold',
                },
                {
                    name: 'Cancelled',
                    value: 'cancelled',
                },
                {
                    name: 'Completed',
                    value: 'completed',
                },
            ]
        }
    },
    methods: {
        isSelected(index) {
            return this.selected === index;
        },
        select(index) {
            if(this.selected === index) {
                this.selected = null;
            } else {
                this.selected = index;
            }
            
            this.updateFilter()
        },
        updateFilter() {
            this.$emit('change', this.selected === null ? null : this.filters[this.selected].value)
        }
    },
    mounted() {
        this.updateFilter()
    }
}
</script>

<style>
    .filters {
        margin-bottom: 10px;
        /* padding: 10px; */
        border-radius: 8px;
        /* background: #e1e1e1; */
    }
    
    .filters .icon {
        margin-right: 15px;
        font-size: 25px;
        vertical-align: middle;
    }

    .filters .filter-item {
        padding: 7.5px 15px;
        margin-right: 10px;
        border-radius: 35px;
        border: 2px solid #e1e1e1;
        cursor: pointer;
        transition: all .3s;
    }


    .filters .filter-item:hover {
        background-color: #f5f5f5;
    }

    .filters .filter-item i {
        margin-left: 5px;
    }

    .filters .filter-item.active {
        border-color: #999;
        background: #eee;
    }
</style>