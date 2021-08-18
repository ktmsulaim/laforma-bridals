<template>
  <div ref="jobsList"></div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListJobs",
  mounted() {
    new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Image",
          formatter: (_, row) =>
            html(`<img src="${row.cells[1].data}" width="80">`),
        },
        {
          name: "Title",
        },
        {
          name: "For",
        },
        {
          name: "Type",
        },
        {
          name: "Status",
          formatter: (_, row) =>
            row.cells[5].data == 1
              ? html(
                  `<span class="badge badge-success badge-pill">Enabled</span>`
                )
              : html(
                  `<span class="badge badge-danger badge-pill">Disabled</span>`
                ),
        },
        {
          name: "Created",
        },
        {
          name: "Action",
          formatter: (_, row) =>
            html(
              `<a href="${row.cells[7].data}" class="btn btn-sm btn-info"><span class="mdi mdi-pencil-box-outline"></span> Edit</a>`
            ),
        },
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("admin.jobs.list"),
        then: (data) =>
          data.map((item, index) => [
            index + 1,
            item.image,
            item.title,
            item.for,
            item.type,
            item.status,
            item.created_at,
            item.edit,
          ]),
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch jobs list.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        summary: false,
      },
    }).render(this.$refs.jobsList);
  },
};
</script>

<style>
</style>