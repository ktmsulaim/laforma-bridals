<template>
  <div>
    <div class="row">
      <div class="col-lg-4">
        <label>Date range</label>
        <date-picker
          placeholder="Select date range"
          value-type="format"
          :range="true"
          format="DD-MM-YYYY"
          v-model="filter.date_range"
          :disabled-date="disabledDate"
          @clear="clearDateRanges"
        ></date-picker>
      </div>
      <div class="col-lg-4">
        <label for="status-options">Status</label>
        <select
          class="form-control"
          v-model="filter.status"
          id="status-options"
        >
          <option value="pending">Pending</option>
          <option value="payment_pending">Payment Pending</option>
          <option value="on_hold">On hold</option>
          <option value="confirmed">Confirmed</option>
          <option value="processing">Processing</option>
          <option value="cancelled">Cancelled</option>
          <option value="refunded">Refunded</option>
        </select>
      </div>
      <div class="col-lg-4">
        <label>&nbsp;</label>
        <div>
          <button
            v-if="filter.filter_enabled"
            class="btn btn-secondary"
            @click="setFilter('remove')"
          >
            <span class="mdi mdi-filter-remove-outline mr-1"></span> Clear
            filter
          </button>
          <button class="btn btn-primary" v-else @click="setFilter('apply')">
            <span class="mdi mdi-filter-outline mr-1"></span> Apply filter
          </button>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-12">
        <div ref="ordersList"></div>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListOrders",
  components: {
    DatePicker,
  },
  data() {
    return {
      grid: null,
      filter: {
        date_range: null,
        status: null,
        filter_enabled: false,
      },
      disabledDate: (date) => {
        return date > moment();
      },
    };
  },
  methods: {
    clearDateRanges() {
      this.filter.date_range = null;
    },
    setFilter(type) {
      if (type === "apply") {
        if (
          !_.isEmpty(this.filter.date_range) ||
          !_.isEmpty(this.filter.status)
        ) {
          this.filter.filter_enabled = true;
        }
      } else if (type === "remove") {
        this.filter.date_range = null;
        this.filter.status = null;
        this.filter.filter_enabled = false;
      }

      this.updateData(type);
    },
    updateData(type) {
      let config;

      if (type === "apply") {
        config = {
          search: true,
          pagination: true,
          server: {
            url: route("admin.orders.list", {
              filter: this.filter.filter_enabled,
              date_range: this.filter.date_range,
              status: this.filter.status,
            }),
            then: (data) =>
              data.data.map((item, index) => [
                item.id,
                item.customer_name,
                item.customer_phone,
                item.total,
                item.status,
                item.created_at,
                item.url.view,
              ]),
            total: (data) => data.count,
            handle: (res) => {
              if (res.status == 400) return { data: [] };
              if (res.ok) return res.json();

              throw Error("Sorry! Unable to fetch orders list.");
            },
          },
        };
      } else {
        config = {
          search: {
            server: {
              url: (prev, keyword) => `${prev}?search=${keyword}`,
            },
            debounceTimeout: 500,
          },
          server: {
            url: route("admin.orders.list"),
            then: (data) =>
              data.data.map((item, index) => [
                item.id,
                item.customer_name,
                item.customer_phone,
                item.total,
                item.status,
                item.created_at,
                item.url.view,
              ]),
            total: (data) => data.count,
            handle: (res) => {
              if (res.status == 400) return { data: [] };
              if (res.ok) return res.json();

              throw Error("Sorry! Unable to fetch orders list.");
            },
          },
          pagination: {
            enabled: true,
            limit: 10,
            server: {
              url: (prev, page, limit) =>
                `${prev}${
                  prev.includes("?") ? "&" : "?"
                }limit=${limit}&offset=${page * limit}`,
            },
            summary: true,
          },
        };
      }

      this.grid.updateConfig(config).forceRender();
    },
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
              color = "secondary";
            } else if (status === "Payment Pending") {
              color = "warning";
            } else if (status === "Confirmed" || status === "Processing") {
              color = "info";
            } else if (status === "Cancelled" || status === "Refunded") {
              color = "danger";
            } else if (status === "Delivered") {
              color = "success";
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
        server: {
          url: (prev, keyword) => `${prev}?search=${keyword}`,
        },
        debounceTimeout: 500,
      },
      server: {
        url: route("admin.orders.list"),
        then: (data) =>
          data.data.map((item, index) => [
            item.id,
            item.customer_name,
            item.customer_phone,
            item.total,
            item.status,
            item.created_at,
            item.url.view,
          ]),
        total: (data) => data.count,
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch orders list.");
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
    }).render(this.$refs.ordersList);
  },
};
</script>

<style>
</style>