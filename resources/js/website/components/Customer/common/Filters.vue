<template>
  <div class="filters">
    <i class="mdi mdi-filter-outline icon"></i>

    <vue-horizontal class="horizontal" :displacement="0.9" :button-between="false" snap="center">
      <template v-slot:btn-prev>
          <svg class="btn-left" viewBox="0 0 24 24">
            <path d="m9.8 12 5 5a1 1 0 1 1-1.4 1.4l-5.7-5.7a1 1 0 0 1 0-1.4l5.7-5.7a1 1 0 0 1 1.4 1.4l-5 5z"/>
          </svg>
        </template>

        <template v-slot:btn-next>
          <svg class="btn-right" viewBox="0 0 24 24">
            <path d="m14.3 12.1-5-5a1 1 0 0 1 1.4-1.4l5.7 5.7a1 1 0 0 1 0 1.4l-5.7 5.7a1 1 0 0 1-1.4-1.4l5-5z"/>
          </svg>
        </template>
      <span
        @click="select(index)"
        v-for="(filter, index) in filters"
        :key="index"
        class="filter-item"
        :class="{ active: isSelected(index) }"
      >
        <span>{{ filter.name }}</span>
        <i v-if="isSelected(index)" class="mdi mdi-close"></i>
      </span>
    </vue-horizontal>
  </div>
</template>

<script>
import VueHorizontal from "vue-horizontal";

export default {
  name: "Filters",
  props: ["for"],
  data() {
    return {
      selected: 0,
      filters: this.getFiltersFor(this.for),
    };
  },
  components: {
    VueHorizontal,
  },
  methods: {
    isSelected(index) {
      return this.selected === index;
    },
    select(index) {
      if (this.selected === index) {
        this.selected = null;
      } else {
        this.selected = index;
      }

      this.updateFilter();
    },
    updateFilter() {
      this.$emit(
        "change",
        this.selected === null ? null : this.filters[this.selected].value
      );
    },
    getFiltersFor(forVal) {
      if (forVal === "bookings") {
        return [
          {
            name: "Booked",
            value: "full_amount_pending",
          },
          {
            name: "Pending",
            value: "pending",
          },
          {
            name: "Booking Charge Pending",
            value: "booking_charge_pending",
          },
          {
            name: "On Hold",
            value: "on_hold",
          },
          {
            name: "Cancelled",
            value: "cancelled",
          },
          {
            name: "Completed",
            value: "completed",
          },
        ];
      } else if (forVal === "orders") {
        return [
          {
            name: "Confirmed",
            value: "confirmed",
          },
          {
            name: "Pending",
            value: "pending",
          },
          {
            name: "Payment Pending",
            value: "payment_pending",
          },
          {
            name: "Processing",
            value: "processing",
          },
          {
            name: "On Hold",
            value: "on_hold",
          },
          {
            name: "Cancelled",
            value: "cancelled",
          },
          {
            name: "Completed",
            value: "completed",
          },
          {
            name: "Refunded",
            value: "refunded",
          },
        ];
      }
    },
  },
  mounted() {
    this.updateFilter();
  },
};
</script>

<style scoped>
.filters {
  margin-bottom: 10px;
  border-radius: 8px;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
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
  transition: all 0.3s;
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

.horizontal {
  flex-shrink: 1;
  flex-grow: 1;
  width: 20%;
}

.btn-left, .btn-right {
  padding: 8px 2px;
  height: 100%;
}

.btn-left {
  background: linear-gradient(to left, #ffffff00 0, #fff 80%, #fff);
}

.btn-right {
  background: linear-gradient(to right, #ffffff00 0, #fff 80%, #fff);
}

</style>