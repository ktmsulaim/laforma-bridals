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
  mounted() {
    new Grid({
      columns: [
        {
          name: "#",
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
            const status = row.cells[3].data;
            return html(`<span class="badge badge-${status === 1 ? 'success' : 'warning'} badge-pill">${status === 1 ? 'Published' : 'Draft'}</span>`)
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
                "customer.reviews.show",
                { review: row.cells[5].data }
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
        url: route("customer.reviews.list"),
        then: (data) =>
          data.data.map((item, index) => [
            parseInt(data.offset) + (index + 1),
            html(
              `<a href="${route("singleProduct", item.product.slug)}">${
                this.str_limit(item.product.name, 15)
              }</a>`
            ),
            this.str_limit(item.title, 15),
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