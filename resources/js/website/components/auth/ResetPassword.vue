<template>
<div class="col-md-6 mx-auto">
  <div class="box_account">
    <div class="form_container">
      <form @submit.prevent="submit">
        <div class="form-group" :class="{ 'is-invalid': hasError('password') }">
          <input
            type="password"
            class="form-control"
            id="password"
            placeholder="Password*"
            v-model="data.password"
            @input="clearError('password')"
          />
          <div v-if="hasError('password')" class="has-error">
            <p>{{ getError("password") }}</p>
          </div>
        </div>
        <div class="form-group">
          <input
            type="password"
            class="form-control"
            id="password_confirmation"
            placeholder="Confirm Password"
            v-model="data.password_confirmation"
          />
        </div>
        <div class="text-center">
          <button :disabled="loading" @click="submit" class="btn_1 full-width">
            <span v-if="loading"
              ><i class="mdi mdi-spin mdi-loading"></i> Processing</span
            >
            <span v-else>Change password</span>
          </button>
        </div>
      </form>
      <div class="mt-2">
        <p class="text-muted">
          Remember password? <a :href="signInUrl">Sign in</a>
        </p>
      </div>
    </div>
    <!-- /form_container -->
  </div>
</div>
</template>

<script>
import Validation from '../../mixins/validation'
export default {
    name: "ResetPassword",
    mixins: [Validation],
    props: ['token'],
    data() {
        return {
            loading: false,
            data: {
                email: null,
                password: null,
                password_confirmation: null,
            }
        }
    },
    computed: {
        signInUrl() {
            return route("customer.login");
        },
    },
    methods: {
        submit() {
            this.loading = true;

            if(this.token) {
                this.data.token = this.token;
            }

            axios.post(route('customer.password.update'), this.data)
            .then(resp => {

                this.$toast.open({
                    message: 'The password has been updated!',
                    type: 'success'
                })

                window.location = route('customer.login')
            })
            .catch(err => {
                this.errors = err.response.data.errors;
                this.$toast.open({
                    message: 'Unable to change the password',
                    type: 'error'
                })
            })
            .finally(() => this.loading = false)
        }
    },
    created() {
        const urlParams = new URLSearchParams(window.location.search)

        if(urlParams.has('email')) {
            this.data.email = urlParams.get('email');
        }
    }
};
</script>

<style>
</style>