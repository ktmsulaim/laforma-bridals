<template>
  <div>
    <span v-for="(option, optionIndex) in options" :key="optionIndex">
      <b>{{ option[0] }}: </b>
      <span v-if="option[0] == 'Color'">
        <span class="color" :style="{ backgroundColor: option[1] }">
          <span class="color-name" :class="getColorNameFontColor(option[1])">{{
            getColorName(option[1])
          }}</span>
        </span>
      </span>
      <span v-else>{{ option[1] }}</span>
    </span>
  </div>
</template>

<script>
var contrast = require("contrast");

export default {
  name: "CartItemOptions",
  props: ["data"],
  data() {
    return {
      contrast
    }
  },
  computed: {
    options() {
      if(this.data) {
        return Object.entries(this.data)
      }
    }
  },
  methods: {
    getColorName(color) {
      if (color) {
        let result = ntc.name(color);
        return result[1];
      }
    },
    getColorNameFontColor(color) {
      if (color) {
        if (this.contrast(color) === "light") {
          return "dark";
        } else {
          return "white";
        }
      }
    },
  },
};
</script>

<style>
.product-options b {
    color: #444;
    font-size: 14px;
}
.product-options span {
    margin-right: 8px;
    font-size: 13px;
}

.product-options {
    color: #666;
    font-size: 14px;
    margin-top: 5px;
}

.product-options .color {
  padding: 3px;
  margin-left: 5px;
  border-radius: 5px;
}
.product-options .color .color-name.white {
  color: #fff;
}
.product-options .color .color-name.dark {
  color: #444;
}
</style>
