<template>
  <div ref="productsList"></div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListProducts",
  mounted() {
    new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Image",
          formatter: (_, row) => html(`<img src="${row.cells[1].data}" width="80">`)
        },
        {
          name: "Name",
        },
        {
          name: "Price",
        },
        {
          name: "Status",
          formatter: (_, row) =>
            row.cells[4].data == 1
              ? html(
                  `<span class="badge badge-success badge-pill">Active</span>`
                )
              : html(
                  `<span class="badge badge-danger badge-pill">Inactive</span>`
                ),
        },
        {
          name: "Created",
          minWidth: 116,
        },
        {
          name: "Action",
          formatter: (_, row) =>
            html(
              `<a href="${row.cells[6].data}" class="btn btn-sm btn-info"><span class="mdi mdi-pencil-box-outline"></span> Edit</a>`
            ),
            minWidth: 120
        },
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("admin.products.list"),
        then: (data) =>
          data.map((item, index) => [
            index + 1,
            item.image,
            item.name,
            item.price,
            item.is_active,
            item.created_at,
            item.edit,
          ]),
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch products list.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        summary: false,
      },
    }).render(this.$refs.productsList);
  },
};
</script>

<style>
</style>