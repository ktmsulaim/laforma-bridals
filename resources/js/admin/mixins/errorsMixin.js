export default {
    methods: {
        isValid(key) {
            if(this.$store.state.errors) {
                console.log(`${key} Has error`);
                return Object.keys(this.$store.state.errors).includes(key);
            }

            return false;
        },
        validate(){
            let errors = {};
            let validations = this.validations;


            _.forIn(this.data, (value, key) => {
                if(Object.keys(validations).includes(key) && validations[key] == 'required' && !value) {
                    errors[key] = `${this.formattedKey(key)} is required`;
                }
            })

            this.$set(this.$store.state.Errors, errors, errors);
          },
          formattedKey(key) {
              if(key) {
                let formatted = key.charAt(0).toUpperCase() + key.slice(1);
                formatted = formatted.replace('_', ' ');
                return formatted;
              }
          },
          hasError(key) {
             let errors = this.$store.state.Errors.errors;

              return Object.keys(errors).includes(key);
          }
    },
    created(){
        const validations = this.validations;
        const data = this.data;

        Object.keys(data).forEach((item) => {
            if(Object.keys(validations).includes(item) && validations[item] == 'required') {
                this.$watch(() => data[item], (oldval, newVal) => {
                    if(!oldval && !this.hasError(item)) {
                        // this.$store.dispatch('assignSingleError', {key: item, value: `${this.formattedKey(item)} is required`})
                        this.$set(this.$store.state.Errors.errors, item, `${this.formattedKey(item)} is required`);
                    } else {
                        if(this.hasError(item)) {
                            // this.$store.commit('removeError', {key:item});
                            this.$delete(this.$store.state.Errors.errors, item);
                        }
                    }
                }, {deep: false, immediate: true});
            }
        })
    }
}