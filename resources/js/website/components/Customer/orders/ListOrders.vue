<template>
<div>
    <filters for="orders" @change="updateList"></filters>
    <div ref="ordersList"></div>
</div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

import Filters from '../common/Filters.vue'

export default {
  name: "ListOrders",
  data() {
    return {
      orders: [],
      filter: null,
      grid: null,
    };
  },
  components:{
    Filters,
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
            server: this.setServer(route("customer.orders.list", { filter: this.filter })),
          })
          .forceRender();
      }
    },
    setServer(url) {
      return {
        url,
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
      };
    }
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
            let color;

             if(status === 'Pending') {
               color = "info";
             } else if (status === 'Payment Pending') {
               color = "info";
             } else if (status === 'Confirmed') {
               color = "primary";
             } else if(status === 'Cancelled') {
               color = "danger";
             } else if (status === 'Completed') {
               color = "success";
             } else if(status === 'On Hold') {
               color = "warning";
             }

             return html(`<span class="badge badge-${color} badge-pill">${status}</span>`)
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
      server: this.setServer(route('customer.orders.list', { filter: this.filter })),
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