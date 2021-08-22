<template>
  <div ref="pagesList"></div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListPages",
  mounted() {
    new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Title",
        },
        {
          name: "Status",
          formatter: (_, row) => html(`<span class="badge badge-pill badge-xl badge-${row.cells[2].data === 1 ? 'success' : 'danger'}">
          ${row.cells[2].data === 1 ? 'Published' : 'Draft'}
          </span>`)
        },
        {
          name: "Created",
        },
        {
          name: "Action",
          formatter: (_, row) =>  html(`<a href="${row.cells[4].data}" class="btn btn-info btn-sm">Edit</a>`)
        },
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("admin.pages.list"),
        then: (data) =>
          data.map((item, index) => [
            index + 1,
            item.title,
            item.status,
            item.created,
            item.url
          ]),
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch reviews list.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        summary: true,
      },
    }).render(this.$refs.pagesList);
  },
};
</script>

<style>
</style>