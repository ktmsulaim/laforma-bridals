<template>
<div>
    <div ref="ordersList">
    </div>
</div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListOrders",
  data() {
    return {
      orders: [],
      filter: null,
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
          name: "Order ID",
          formatter: (_, row) => `#${row.cells[1].data}`
        },
        {
          name: "Total",
        },
        {
          name: "Status",
          formatter: (_, row) => {
            let status = row.cells[3].data;
             if(status === 'Pending') {
               return html(
                  `<span class="badge badge-info badge-pill">Pending</span>`
                )
             } else if (status === 'Payment Pending') {
               return html(
                  `<span class="badge badge-warning badge-pill">Payment Pending</span>`
                )
             } else if (status === 'Confirmed') {
               return html(
                  `<span class="badge badge-info badge-pill">Confirmed</span>`
                )
             } else if(status === 'Cancelled') {
               return html(
                  `<span class="badge badge-danger badge-pill">Cancelled</span>`
                )
             } else if (status === 'Completed') {
               return html(
                  `<span class="badge badge-success badge-pill">Completed</span>`
                )
             }
          },
        },
        {
          name: "Date",
        },
        {
          name: "Action",
          formatter: (_, row) =>
            html(
              `<a href="${row.cells[5].data}" class="btn btn-sm btn-info"><span class="mdi mdi-eye-outline"></span> View</a>`
            ),
        },
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("customer.orders.list"),
        then: (data) => {
          this.orders = data.data;
          return this.orders.map((item, index) => [
            index + 1,
            item.id,
            item.total,
            item.status,
            item.created_at,
            item.url.view,
          ])
        },
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();
          this.$toast.open({
            message: 'Unable to fetch the orders',
            type: 'error'
          })
          // throw Error("Sorry! Unable to fetch the orders.");
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