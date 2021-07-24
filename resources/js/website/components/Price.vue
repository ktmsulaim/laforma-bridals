<template>
  <div class="price_main">
    <span v-if="options.has_special_price" class="old_price">{{
      price.price
    }}</span>
    <span class="new_price">
      <span v-if="options.has_special_price">{{
        price.special_price
      }}</span>
      <span v-else>{{ price.price }}</span>
    </span>
    <span v-if="options.show_percentage" class="percentage"
      >-{{ price.percentage }}%</span>
  </div>
</template>

<script>
export default {
  name: "Price",
  props: ['price', 'options'],
};
</script>

<style>
.price_main {
    margin: 8px 0;
}
</style>