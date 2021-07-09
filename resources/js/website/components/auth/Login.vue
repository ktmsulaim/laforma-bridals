<template>
  <div class="box_account">
    <div class="form_container">
      <div class="row no-gutters">
        <div class="col-lg-6 pr-lg-1">
          <a href="#0" class="social_bt facebook">Sign in with Facebook</a>
        </div>
        <div class="col-lg-6 pl-lg-1">
          <a href="#0" class="social_bt google">Sign in with Google</a>
        </div>
      </div>
      <div class="divider"><span>Or</span></div>
     <form @submit.prevent="submit">
          <div class="form-group" :class="{ 'is-invalid': hasError('username') }">
          <input
            type="text"
            class="form-control"
            id="username"
            placeholder="Username"
            v-model="data.username"
          />
          <div v-if="hasError('username')" class="has-error">
            <p>{{ getError("username") }}</p>
          </div>
        </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('password') }">
        <input
          type="password"
          class="form-control"
          id="password"
          placeholder="Password*"
          v-model="data.password"
        />
        <div v-if="hasError('password')" class="has-error">
            <p>{{ getError("password") }}</p>
          </div>
      </div>
      <div class="clearfix add_bottom_15">
        <div class="checkboxes float-left">
          <label class="container_check"
            >Remember me
            <input type="checkbox" v-model="data.remember" />
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="float-right">
          <a href="javascript:void(0);">Lost Password?</a>
        </div>
      </div>
      <div class="text-center">
          <button :disabled="loading" @click="submit" class="btn_1 full-width">
              Sign in
          </button>
      </div>
     </form>
      <div class="mt-2">
          <p class="text-muted">New to La'forma bridals? <a :href="registerUrl">Sign up</a></p>
      </div>
    </div>
    <!-- /form_container -->
  </div>
</template>

<script>
import Validation from '../../mixins/validation'
export default {
  name: "Login",
  mixins: [Validation],
  props: ['redirect'],
  data() {
      return {
          loading: false,
          data: {
              username: null,
              password: null,
              remember: false,
          }
      }
  },
  computed:{
      registerUrl() {
          return route("customer.register")
      }
  },
  methods: {
      submit() {
          this.loading = true;
          axios.post(route('customer.login.post'), this.data)
          .then(resp => {
            this.$toast.open({
              message: 'You have successfully signed in.',
              type: 'success'
            })

            if(this.redirect) {
              window.location = route('customer.dashboard')
            } else {
              this.$store.commit('authenticate', resp.data)
            }

          })
          .catch(err => {
            this.$toast.open({
              message: 'Unable to proccess the request',
              type: 'error'
            })

            this.errors = err.response.data.errors;
          })
          .finally(() => {
              this.loading = false;
          })
      }
  },
};
</script>

<style>
</style>