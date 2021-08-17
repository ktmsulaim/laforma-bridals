<template>
  <div>
    <div ref="reviewsList"></div>
  </div>
</template>

<script>
import { Grid, html, h } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListReviews",
  data() {
    return {
      grid: null,
      selected: null,
    };
  },
  methods: {
    refreshReviews() {
            this.$nextTick(() => {
                this.grid.forceRender();
            })
        },
    updateStatus(id, status) {
      console.log(id, status);

      if (id) {
        this.selected = id;
      }

      this.$swal({
          titleText: `${status === 1 ? 'Publish the review?' : 'Draft the review?'}`,
          icon: `${status === 1 ? 'success' : 'warning'}`,
          allowOutsideClick: false,
          showCancelButton: true,
          confirmButtonText: 'Change',
          confirmButtonColor: `${status === 1 ? '#10c469' : '#f9c851'}`,
      })
      .then(result => {
          if(result.isConfirmed) {
              axios.post(route('admin.reviews.update', {review: id}), {status})
              .then(resp => {
                  this.$swal('The status has been updated', '', 'success')
                  this.reset()
              })
              .catch(error => {
                  this.$swal('Sorry! Unable to update the status', '', 'error')
              })
          }
      })
      .catch(error => {
          this.$swal('Sorry! Unable to update the status. Try again later', '', 'error')
      })
    },
    reset() {
      this.selected = false;
      this.refreshReviews()
    }
  },
  mounted() {
    this.grid = new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Reviewer",
        },
        {
          name: "Product",
        },
        {
          name: "Title",
        },
        {
          name: "Status",
          formatter: (_, row) => {
            const id = row.cells[6].data;
            const status = row.cells[4].data;
            const newStatus = status === 1 ? 0 : 1;

            return h(
              "button",
              {
                className: `btn  btn-sm ${
                  status === 1 ? "btn-success" : "btn-warning"
                }`,
                onClick: () => this.updateStatus(id, newStatus),
              },
               status === 1
                ? ["Published"]
                : ["Draft"]
            );
          },
        },
        {
          name: "Created",
        },
        {
          name: "Actions",
          formatter: (_, row) =>
            html(
              `<a class="btn btn-link btn-sm" href="${route(
                "admin.reviews.show",
                { review: row.cells[6].data }
              )}">View</a>`
            ),
        },
      ],
      search: {
        server: {
          url: (prev, keyword) => `${prev}?search=${keyword}`,
        },
        debounceTimeout: 500,
      },
      server: {
        url: route("admin.reviews.list"),
        then: (data) =>
          data.data.map((item, index) => [
            parseInt(data.offset) + (index + 1),
            item.reviewer_name,
            html(
              `<a href="${route("admin.products.show", item.product.id)}">${
                item.product.name
              }</a>`
            ),
            item.title,
            item.status,
            item.created.formatted,
            item.id,
          ]),
        total: (data) => data.count,
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch reviews list.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        server: {
          url: (prev, page, limit) =>
            `${prev}${prev.includes("?") ? "&" : "?"}limit=${limit}&offset=${
              page * limit
            }`,
        },
        summary: true,
      },
    }).render(this.$refs.reviewsList);
  },
};
</script>

<style>
</style>