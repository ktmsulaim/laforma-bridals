<template>
  <div class="mb-3">
    <button :disabled="loading" class="btn btn-info" @click="print">
      <div v-if="loading">
        <span class="mdi mdi-loading mdi-spin"></span> Printing
      </div>
      <div v-else><span class="mdi mdi-printer"></span> Print</div>
    </button>
  </div>
</template>

<script>
export default {
  name: "PrintInvoice",
  props: ["source", 'styles'],
  data() {
    return {
      loading: false,
      output: null,
    };
  },
  methods: {
    async print() {
      this.loading = true;

      await this.$htmlToPaper(this.source, {
        name: "_blank",
        specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
        styles: [
            ...this.styles,
            "https://unpkg.com/kidlat-css/css/kidlat.css",
        ],
        timeout: 1000, // default timeout before the print window appears
        autoClose: true, // if false, the window will not close after printing
        windowTitle: window.document.title, // override the window title
      });

      this.loading = false;
    },
  },
  mounted() {
    this.print();
  },
};
</script>

<style>
</style>