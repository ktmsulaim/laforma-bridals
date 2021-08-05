export default {
    data() {
        return {
            availability: {
                status: false,
                selectedDate: null,
                selectedTime: null,
                loading: false,
                slots: [],
              },
        }
    },
    computed:  {
      validDateTime() {
        return (
          !_.isEmpty(this.availability.selectedDate) &&
          !_.isEmpty(this.availability.selectedTime)
        );
      },
    },
    methods: {
        disabledDates(date) {
            const today = moment().startOf("day");
            date = moment(date).startOf("day");
            let holidays = [];
      
            if (Settings.holidays) {
              holidays = Settings.holidays.split(",");
            }
      
            return (
              holidays.includes(date.format("DD/MM/YYYY")) ||
              date === today ||
              date < today
            );
          },
          checkAvailability() {
            if (this.availability.selectedDate) {
              this.availability.loading = true;
      
              axios
                .post(
                  route("packages.check.availability", { package: this.packages.id }),
                  { date: this.availability.selectedDate }
                )
                .then((resp) => {
                  let slots = resp.data;
                  let formattedDate = moment(
                    this.availability.selectedDate,
                    "YYYY-MM-DD"
                  ).format("DD-MM-YYYY");
      
                  this.availability.slots = slots;
                  this.availability.status = slots.length > 0;
      
                  if (slots.length) {
                    this.$toast.open({
                      message: `The package is available to book on ${formattedDate}`,
                      type: "success",
                    });
                  } else {
                    this.$toast.open({
                      message: `Sorry! the package is not available to book on ${formattedDate}`,
                      type: "error",
                    });
                  }
                })
                .catch((err) =>
                  this.$toast.open({
                    message: "Unable to check availability",
                    type: "error",
                  })
                )
                .finally(() => (this.availability.loading = false));
            }
          },
          resetAvailabilityStatus() {
            this.availability.status = false;
            this.availability.selectedTime = null;
            this.availability.loading = false;
            this.booking.loading = false;
            this.loading = false;
          },
    }
}