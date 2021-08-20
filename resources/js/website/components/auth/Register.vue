<template>
  <div class="box_account">
    <div class="form_container">
      <social-auth :redirect="redirect"></social-auth>
      <div class="divider"><span>Or</span></div>
      <form @submit.prevent="submit">
        <div class="form-group" :class="{ 'is-invalid': hasError('name') }">
          <input
            type="text"
            class="form-control"
            id="name"
            placeholder="Full name"
            v-model="data.name"
            @input="clearError('name')"
          />
          <div v-if="hasError('name')" class="has-error">
            <p>{{ getError("name") }}</p>
          </div>
        </div>
        <div class="form-group" :class="{ 'is-invalid': hasError('username') }">
          <input
            type="text"
            class="form-control"
            id="username"
            placeholder="Username"
            v-model="data.username"
            @input="clearError('username')"
          />
          <div v-if="hasError('username')" class="has-error">
            <p>{{ getError("username") }}</p>
          </div>
        </div>
        <div class="form-group" :class="{ 'is-invalid': hasError('email') }">
          <input
            type="email"
            class="form-control"
            id="email"
            placeholder="Email"
            v-model="data.email"
            @input="clearError('email')"
          />
          <div v-if="hasError('email')" class="has-error">
            <p>{{ getError("email") }}</p>
          </div>
        </div>
        <div class="form-group" :class="{ 'is-invalid': hasError('phone') }">
          <input
            type="tel"
            class="form-control"
            id="phone"
            placeholder="Phone"
            v-model="data.phone"
            @input="clearError('phone')"
          />
          <div v-if="hasError('phone')" class="has-error">
            <p>{{ getError("phone") }}</p>
          </div>
        </div>
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
          <button @click="submit" :disabled="loading" class="btn_1 full-width">
            <span v-if="loading">Proccessing</span>
            <span v-else>Sign up</span>
          </button>
        </div>
      </form>
      <div class="mt-2">
        <p class="text-muted">
          Already a member? <a :href="signInUrl">Sign in</a>
        </p>
      </div>
    </div>
    <!-- /form_container -->
  </div>
</template>

<script>
import Validation from '../../mixins/validation'

import SocialAuth from './SocialAuth.vue'
export default {
  name: "Register",
  mixins: [Validation],
  components: {
    SocialAuth,
  },
  props: ['redirect'],
  data() {
    return {
      loading: false,
      data: {
        name: null,
        username: null,
        email: null,
        phone: null,
        password: null,
        password_confirmation: null,
        remember: false,
      },
    };
  },
  computed: {
    signInUrl() {
      return route("customer.login");
    },
  },
  methods: {
    submit() {
      this.loading = true;
      axios
        .post(route("customer.register.post"), this.data)
        .then((resp) => {
          this.$toast.open({
            message: "Success! your account has been created",
            type: "success",
          });

          window.location = route('customer.verification.notice')
        })
        .catch((err) => {
          this.$toast.open({
            message: "Unable to proccess the request",
            type: "error",
          });

          this.errors = err.response.data.errors;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>