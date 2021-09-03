<template>
  <div>
    <div class="row">
      <div class="col-lg-3">
        <label>Date range</label>
        <date-picker
          placeholder="Select date range"
          value-type="format"
          :range="true"
          format="DD-MM-YYYY"
          v-model="filter.date_range"
          @change="filter.filter_enabled = false"
          @clear="clearDateRanges"
        ></date-picker>
      </div>
      <div class="col-lg-3">
        <label for="status-options">Status</label>
        <select
          class="form-control"
          v-model="filter.status"
          @change="filter.filter_enabled = false"
          id="status-options"
        >
          <option value="pending">Pending</option>
          <option value="booking_charge_pending">Booking Charge Pending</option>
          <option value="full_amount_pending">Booked</option>
          <option value="completed">Completed</option>
          <option value="on_hold">On hold</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>
      <div class="col-lg-2">
        <label for="progress-options">Progress</label>
        <select
          class="form-control"
          v-model="filter.progress"
          @change="filter.filter_enabled = false"
          id="progress-options"
        >
          <option value="not_started">Not started</option>
          <option value="in_progress">In progress</option>
          <option value="finished">Finished</option>
        </select>
      </div>
      <div class="col-lg-3">
        <package-list @set="selectPackage" ref="packageListComponent"></package-list>
      </div>
      <div class="col-lg-1">
        <label>&nbsp;</label>
        <div>
          <button
            v-if="filter.filter_enabled"
            class="btn btn-secondary"
            @click="setFilter('remove')"
          >
            <span class="mdi mdi-close"></span>
          </button>
          <button class="btn btn-primary" v-else @click="setFilter('apply')">
            <span class="mdi mdi-check"></span>
          </button>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-12">
        <div ref="bookingsList"></div>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import PackageList from './PackageList.vue'

export default {
  name: "ListBookings",
  components: {
    DatePicker,
    PackageList,
  },
  data() {
    return {
      grid: null,
      filter: {
        date_range: null,
        status: null,
        progress: null,
        package: null,
        filter_enabled: false,
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
          !_.isEmpty(this.filter.status) ||
          !_.isEmpty(this.filter.progress) ||
          !_.isEmpty(this.filter.package)
        ) {
          this.filter.filter_enabled = true;
        }
      } else if (type === "remove") {
        this.filter.date_range = null;
        this.filter.status = null;
        this.filter.progress = null;
        this.filter.package = null;
        this.filter.filter_enabled = false;

        this.$refs.packageListComponent.clear();
      }

      this.updateData(type);
    },
    setServer(filter = false) {
        let data;

        if(filter) {
            data = {
              filter: this.filter.filter_enabled,
              date_range: this.filter.date_range,
              status: this.filter.status,
              progress: this.filter.progress,
              package: this.filter.package,
            };
        }

        return {
            url: route("admin.bookings.list", data),
            then: (data) =>
              data.data.map((item, index) => [
                index + 1,
                item.customer_name,
                item.customer_phone,
                item.package,
                item.date,
                item.time,
                item.status,
                item.progress,
                item.url.view,
              ]),
            total: (data) => data.count,
            handle: (res) => {
              if (res.status == 400) return { data: [] };
              if (res.ok) return res.json();

              throw Error("Sorry! Unable to fetch bookings list.");
            },
          };
    },
    updateData(type) {
      let config;

      if (type === "apply") {
        config = {
          search: true,
          pagination: true,
          server: this.setServer(true),
        };
      } else {
        config = {
          search: {
            server: {
              url: (prev, keyword) => `${prev}?search=${keyword}`,
            },
            debounceTimeout: 500,
          },
          server: this.setServer(),
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
    selectPackage(value) {
      this.filter.package = value;

      if(this.filter.filter_enabled) {
        this.filter.filter_enabled = false;
      }
    }
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
          name: "Package",
        },
        {
          name: "Date",
        },
        {
          name: "Time",
        },
        {
          name: "Status",
          formatter: (_, row) => {
            let status = row.cells[6].data;
            let color, badge;

            if (status === "Pending") {
              color = "secondary";
            } else if (status === "Booking Charge Pending" || status === 'On Hold') {
              color = "warning";
            } else if (status === "Booked" || status === "Full Amount Pending") {
              color = "info";
            } else if (status === "Cancelled" || status === "Refunded") {
              color = "danger";
            } else if (status === "Completed") {
              color = "success";
            } else {
              color = "secondary";
            }

            badge = `<span class="badge badge-${color} badge-pill badge-xl">${status}</span>`;

            return html(badge);
          },
        },
        {
          name: "Progress",
        },
        {
          name: "Action",
          formatter: (_, row) =>
            html(
              `<a href="${row.cells[8].data}" class="btn btn-sm btn-primary"><span class="mdi mdi-eye-outline"></span> View</a>`
            ),
        },
      ],
      search: {
        server: {
          url: (prev, keyword) => `${prev}?search=${keyword}`,
        },
        debounceTimeout: 500,
      },
      server: this.setServer(false),
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
    }).render(this.$refs.bookingsList);
  },
};
</script>

<style>
</style>