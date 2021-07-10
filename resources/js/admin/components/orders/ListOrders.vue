<template>
  <div ref="ordersList"></div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListOrders",
  data() {
    return {
      grid: null,
    };
  },
  mounted() {
    this.grid = new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Name",
        },
        {
          name: "Phone",
        },
        {
          name: "Total",
          formatter: (_, row) => this.formatMoney(row.cells[3].data),
        },
        {
          name: "Status",
          formatter: (_, row) => {
            let status = row.cells[4].data;
            let color, badge;

            if (status === "Pending") {
                color = 'secondary';
            } else if(status === 'Payment Pending') {
                color = 'warning';
            } else if(status === 'Confirmed' || status === 'Processing') {
                color = 'info';
            } else if(status === 'Cancelled' || status === 'Refunded') {
                color = 'danger';
            } else if(status === 'Delivered') {
                color = 'success';
            } else {
                color = "secondary";
            }

            badge = `<span class="badge badge-${color} badge-pill badge-xl">${status}</span>`;

            return html(badge);
          },
        },
        {
          name: "Created",
        },
        {
          name: "Action",
          formatter: (_, row) =>
            html(
              `<a href="${row.cells[6].data}" class="btn btn-sm btn-primary"><span class="mdi mdi-eye-outline"></span> View</a>`
            ),
        },
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("admin.orders.list"),
        then: (data) =>
          data.map((item, index) => [
            item.id,
            item.customer_name,
            item.customer_phone,
            item.total,
            item.status,
            item.created_at,
            item.url.view,
          ]),
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch orders list.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        summary: false,
      },
    }).render(this.$refs.ordersList);
  },
};
</script>

<style>
</style>