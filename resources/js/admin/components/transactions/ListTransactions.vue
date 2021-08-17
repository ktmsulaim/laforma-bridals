<template>
  <div ref="transactionsList"></div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListTransactions",
  mounted() {
    new Grid({
      columns: [
        {
          name: "#",
        },
        {
          name: "Order ID",
        },
        {
          name: "Transaction ID",
        },
        {
          name: "Amount",
        },
        {
          name: "Created",
        },
      ],
      search: {
        enabled: true,
      },
      server: {
        url: route("admin.transactions.list"),
        then: (data) =>
          data.data.map((item, index) => [
            index + 1,
            html(`<a href="${item.urls.order}">#${item.order_id}</a>`),
            item.transaction_id,
            item.amount,
            item.created_at,
            item.urls.order,
          ]),
        total: (data) => data.count,
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch transactions list.");
        },
      },
      pagination: {
        enabled: true,
        limit: 10,
        server: {
          url: (prev, page, limit) =>
            `${prev}?limit=${limit}&offset=${page * limit}`,
        },
        summary: true,
      },
    }).render(this.$refs.transactionsList);
  },
};
</script>

<style>
</style>