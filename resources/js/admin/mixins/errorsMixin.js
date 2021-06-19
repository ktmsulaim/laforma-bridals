export default {
    computed: {
        hasErrors() {
            const errors = this.$store.state.Errors.errors;
            return  errors && Object.keys(errors).length;
        }
    },
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
    mounted(){
        this.$store.commit('resetErrors');

        const validations = this.validations;
        const data = this.data;
        const mode = this.mode;

        Object.keys(data).forEach((item) => {
            if(Object.keys(validations).includes(item) && validations[item] == 'required') {
                this.$watch(() => data[item], (oldval, newVal) => {
                    if((!this.hasError(item) && !oldval) || !oldval) {
                    
                        this.$set(this.$store.state.Errors.errors, item, `${this.formattedKey(item)} is required`);
                        this.$store.dispatch('assignSingleError', {key: item, value: `${this.formattedKey(item)} is required`})
                        
                    } else {
                        this.$delete(this.$store.state.Errors.errors, item);
                        this.$store.commit('removeError', {key: item})
                    }
                }, {deep: false, immediate: true});
            }
        })
    }
}