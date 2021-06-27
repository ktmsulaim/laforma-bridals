export default {
    data() {
        return {
            errors: [],
        }
    },
    methods: {
        hasError(key) {
            return Object.keys(this.errors).includes(key);
          },
          getError(key) {
            if (this.hasError(key)) {
              return this.errors[key][0];
            }
          },
          clearError(key) {
            if (this.hasError(key)) {
              delete this.errors[key];
            }
          },
    }
}