<template>
  <div class="row my-2">
    <div class="col">
      <table class="table border table-hover">
        <thead>
          <tr>
            <th></th>
            <th>Label</th>
            <th>Price</th>
            <th>Type</th>
            <th>In stock</th>
            <th></th>
          </tr>
        </thead>

        <draggable
          tag="tbody"
          v-if="values && values.length"
          v-model="values"
          @end="sortValues"
          handle=".dragger"
        >
          <tr v-for="(value, index) in values" :key="index">
            <td class="text-center icon">
              <div class="mdi mdi-drag-variant dragger"></div>
            </td>
            <td>
              <v-swatches
                v-model="values[index].label"
                v-if="type === 'color'"
                swatches="text-advanced"
              ></v-swatches>
              <input
                v-else
                type="text"
                v-model="values[index].label"
                class="form-control"
              />
            </td>
            <td>
              <input
                type="number"
                min="0"
                @input="checkPrice(index)"
                v-model="values[index].price"
                class="form-control"
              />
            </td>
            <td>
              <select class="form-control" v-model="values[index].price_type">
                <option value="fixed">Fixed</option>
                <option value="percentage">Percentage</option>
              </select>
            </td>
            <td>
              <div class="custom-control custom-switch">
                <input
                    type="checkbox"
                    :id="`in_stock-${optionName}-${index}`"
                    class="custom-control-input"
                    v-model="values[index].in_stock"
                />
                <label :for="`in_stock-${optionName}-${index}`" class="custom-control-label"
                    ></label
                >
                </div>
            </td>
            <td class="text-center icon">
              <span @click="removeValue(index)" class="mdi mdi-delete"></span>
            </td>
          </tr>
        </draggable>
        <tbody v-else>
          <tr>
            <td colspan="5">No values were added</td>
          </tr>
        </tbody>
      </table>
      <button @click="addValue" class="btn btn-secondary">
        <span class="mdi mdi-plus mr-2"></span>
        <span>Add value</span>
      </button>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import VSwatches from "vue-swatches";
import "vue-swatches/dist/vue-swatches.css";
export default {
  name: "OptionValue",
  components: {
    draggable,
    VSwatches,
  },
  props: ["type", "option"],
  data() {
    return {
      values: [],
    };
  },
  computed: {
    position() {
      if (this.values.length) {
        return this.values.length + 1;
      } else {
        return 1;
      }
    },
    optionName() {
      return _.kebabCase(this.option.name);
    }
  },
  methods: {
    addValue() {
      this.values.push({
        id: null,
        position: this.position,
        label: null,
        price: 0,
        price_type: "fixed",
        in_stock: 1,
      });
    },
    removeValue(index) {
      this.values.splice(index, 1);
    },
    updateValues() {
      this.$emit("updateValues", this.values);
    },
    sortValues() {
      this.values.forEach((item, index) => (item.position = index + 1));
    },
    checkPrice(index) {
      if (this.values[index].price < 0) {
        this.values[index].price = 0;
      }
    },
  },
  watch: {
    values(oldValue, newValue) {
      this.updateValues();
    },
  },
  created() {
    if (this.option && this.option.values && this.option.values.length) {
      this.values = this.option.values.map((value) => ({
        id: value.id,
        label: value.label,
        price: value.price,
        price_type: value.price_type,
        position: value.position,
        in_stock: value.in_stock,
      }));
    }
  },
};
</script>

<style>
.icon {
  display: flex;
  height: 100%;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}

.icon .mdi {
  color: #999;
}

.icon .mdi:hover {
  cursor: pointer;
  color: #444;
}

.icon .mdi.mdi-delete:hover {
  color: red;
}
</style>