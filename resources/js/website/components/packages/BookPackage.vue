<template>
  <div>
    <div class="form-group row align-items-end">
      <div class="col-lg-6">
        <label for="date">Check availability</label>
        <date-picker :disabled="availability.loading" value-type="YYYY-MM-DD" format="DD-MM-YYYY" input-class="form-control" v-model="availability.selectedDate" :disabled-date="disabledDates"></date-picker>
      </div>
      <div class="col-lg-6 mt-2 mt-md-0">
        <button :disabled="availability.loading" class="btn_1" @click="checkAvailability">
            <span v-if="availability.loading"><span class="mdi mdi-loading mdi-spin"></span></span>
            <span v-else>Check</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
  name: "BookPackage",
  props: ["package_id"],
  components: {
      DatePicker
  },
  data() {
    return {
      availability: {
          status: false,
          selectedDate: null,
          loading: false,
      },
    };
  },
  methods: {
      disabledDates(date) {
      const today = moment().startOf('day')
      date = moment(date).startOf('day')

      return date === today || date < today
    },
    checkAvailability() {
        if(this.availability.selectedDate) {
            this.availability.loading = true;
        }  
    }
  }
};
</script>

<style>
</style>