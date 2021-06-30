<template>
  <div>
    <div class="mb-2">
      <div class="row">
        <div class="col-md-3">
          <label for="filter"><span class="mdi mdi-filter"></span> Filter</label>
          <select v-model="data.filter" class="form-control" id="filter">
            <option value=1>Enable</option>
            <option value=0>Disable</option>
          </select>
        </div>
        <div class="col-md-3" v-if="data.filter == 1">
          <label for="filter">Status</label>
          <select v-model="data.status" class="form-control" id="filter">
            <option :value="null">None</option>
            <option :value="1">Active</option>
            <option :value="0">Inactive</option>
          </select>
        </div>
        <div class="col-md-3" v-if="data.filter == 1">
          <label for="filter">Verification</label>
          <select v-model="data.verification" class="form-control" id="filter">
             <option :value="null">None</option>
            <option :value="1">Verified</option>
            <option :value="0">Not verified</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="">&nbsp;</label>
          <div>
            <button :disabled="data.filter != 1" class="btn btn-info" @click="reload">Go</button>
          </div>
        </div>
      </div>
    </div>
    <div class="list" ref="customersList"></div>
  </div>
</template>

<script>
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

export default {
  name: "ListCustomers",
  data() {
    return {
      data: {
        filter: 0,
        status: null,
        verification: null,
      },
      grid: null,
    }
  },
  computed:{
    url() {
      return 
      
    }
  },
  methods: {
    handleServerData(url) {
      return {
        url,
        then: (data) =>
          data.map((item, index) => [
            index + 1,
            item.photo,
            item.name,
            item.phone,
            item.verified,
            item.status,
            item.created,
            item.view,
          ]),
        handle: (res) => {
          if (res.status == 400) return { data: [] };
          if (res.ok) return res.json();

          throw Error("Sorry! Unable to fetch customers list.");
        }
        };
    },
    reload() {
      if(this.data.filter == 1) {
        this.grid.updateConfig({
          server: this.handleServerData(route('admin.customers.list', this.data))
        }).forceRender();
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
          name: "Photo",
          formatter: (_, row) =>
            html(`<img src="${row.cells[1].data}" width="50">`),
        },
        {
          name: "Name",
        },
        {
          name: "Phone",
        },
        {
          name: "Verified",
          formatter: (_, row) =>
            row.cells[4].data
              ? row.cells[4].data
              : html(
                  `<span class="badge badge-danger badge-pill">Not verified</span>`
                ),
        },
        {
          name: "Status",
          formatter: (_, row) =>
            row.cells[5].data
              ? html(
                  `<span class="badge badge-success badge-pill">Active</span>`
                )
              : html(
                  `<span class="badge badge-danger badge-pill">Inactive</span>`
                ),
        },
        {
          name: "Created",
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
      server: this.handleServerData(route('admin.customers.list')),
      pagination: {
        enabled: true,
        limit: 10,
        summary: true,
      },
    }).render(this.$refs.customersList);
  },
};
</script>

<style></style>
