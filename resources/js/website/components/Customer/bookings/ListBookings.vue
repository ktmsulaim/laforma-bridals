<template>
  <div>
    <filters for="bookings" @change="updateList"></filters>
    <div ref="bookingsList"></div>
  </div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

import Filters from "../common/Filters.vue";

export default {
  name: "ListBookings",
  components: {
    Filters,
  },
  data() {
    return {
      filter: null,
      grid: null,
    };
  },
  methods: {
    updateList(filter) {
      if(!_.isEmpty(filter)) {
        this.filter = filter;
      } else {
        this.filter = null
      }

      this.refreshList();
    },
    refreshList() {
      if(this.grid) {
        this.grid
          .updateConfig({
            server: this.setServer(route("customer.bookings.list", { filter: this.filter })),
          })
          .forceRender();
      }
    },
    setServer(url) {
      return {
        url: url,
        then: (data) => {
          return data.map((item, index) => [
            index + 1,
            item.package,
            item.time,
            item.date,
            item.status,
            item.progress,
            item.booked_on,
            item.url.view,
          ]);
        },
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();
          this.$toast.open({
            message: "Unable to fetch the bookings",
            type: "error",
          });
        },
      };
    },
  },
  mounted() {
    this.grid = new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Package",
        },
        {
          name: "Time",
        },
        {
          name: "Date",
        },
        {
          name: "Status",
          formatter: (_, row) => {
            let status = row.cells[4].data;
            if (status === "Pending") {
              return html(
                `<span class="badge badge-info badge-pill">Pending</span>`
              );
            } else if (status === "Booking Charge Pending") {
              return html(
                `<span class="badge badge-warning badge-pill">Booking Charge Pending</span>`
              );
            } else if (status === "Full Amount Pending") {
              return html(
                `<span class="badge badge-info badge-pill">Booked</span>`
              );
            } else if (status === "Cancelled") {
              return html(
                `<span class="badge badge-danger badge-pill">Cancelled</span>`
              );
            } else if (status === "Completed") {
              return html(
                `<span class="badge badge-success badge-pill">Completed</span>`
              );
            }
          },
        },
        {
          name: "Progress",
        },
        {
          name: "Booked on",
        },
        {
          name: "Action",
          formatter: (_, row) =>
            html(
              `<a href="${row.cells[7].data}" class="btn btn-sm btn-info"><span class="mdi mdi-eye-outline"></span> View</a>`
            ),
        },
      ],
      search: {
        enabled: true,
      },
      server: this.setServer(route("customer.bookings.list", { filter: this.filter })),
      pagination: {
        enabled: true,
        limit: 10,
        summary: false,
      },
    }).render(this.$refs.bookingsList)
  },
};
</script>

<style>
</style>