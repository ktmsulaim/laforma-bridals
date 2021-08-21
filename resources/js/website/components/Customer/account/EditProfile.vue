<template>
  <div>
       <div class="form-group" :class="{ 'is-invalid': hasError('name') }">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" v-model="data.name">
          
          <div v-if="hasError('name')" class="has-error">
            <p>{{ getError("name") }}</p>
          </div>
      </div>
      <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" class="form-control" readonly :value="customer.email">
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('username') }">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" v-model="data.username">
          
          <div v-if="hasError('username')" class="has-error">
            <p>{{ getError("username") }}</p>
          </div>
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('phone') }">
          <label for="phone">Phone</label>
          <input type="tel" class="form-control" id="phone" v-model="data.phone">
          
          <div v-if="hasError('phone')" class="has-error">
            <p>{{ getError("phone") }}</p>
          </div>
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('password') }">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" v-model="data.password">
          
          <div v-if="hasError('password')" class="has-error">
            <p>{{ getError("password") }}</p>
          </div>
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('password_confirmation') }">
          <label for="password_confirmation">Confirm Password</label>
          <input type="password" class="form-control" id="password_confirmation" v-model="data.password_confirmation">
          
          <div v-if="hasError('password_confirmation')" class="has-error">
            <p>{{ getError("password_confirmation") }}</p>
          </div>
      </div>
      <div class="form-group">
          <button class="btn_1" @click="save" :disabled="submit.loading">
              <span v-if="submit.loading">
                  <i class="mdi mdi-loading mdi-spin"></i>
                  <span> Processing</span>
              </span>
              <span v-else>Save</span>
          </button>
      </div>
  </div>
</template>

<script>
import ValidationMixin from '../../../mixins/validation'
export default {
    name: "EditProfile",
    props: ['customer'],
    mixins: [ValidationMixin],
    data() {
        return {
            submit: {
                loading: false,
            },
            data: {
                name: this.customer.name,
                username: this.customer.username,
                phone: this.customer.phone,
                password: null,
                password_confirmation: null,
            },
            errors: [],
        }
    },
    methods: {
        save() {
            this.submit.loading = true;
            this.errors = [];

            axios.post(route('customer.account.basic'), this.data)
            .then(resp => {
                this.$toast.open({
                    message: 'The profile has been updated',
                    type: 'success'
                })
            })
            .catch(err => {
                this.errors = err.response.data.errors;
                this.$toast.open({
                    message: 'Unable to save the changes',
                    type: 'error'
                })
            })
            .finally(() => this.submit.loading = false)
        }
    }
}
</script>

<style>

</style>