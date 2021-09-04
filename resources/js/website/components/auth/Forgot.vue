<template>
  <div>
    <span class="forgot-trigger" @click="openForgotModal">Lost password?</span>

    <modal name="forgotModal" :adaptive="true" height="auto" :scrollable="true">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Forgot password?</h4>

            <div v-if="email_sent">
                <p>The password reset link has been sent to ({{data.email}}). You can just click on the link to reset the password.</p>
            </div>
          <div v-else>
            <p>Enter your email address to recover the password</p>
            <form @submit.prevent="submit" action="" method="post">
              <div
                class="form-group"
                :class="{ 'is-invalid': hasError('email') }"
              >
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="Email"
                  v-model="data.email"
                />
                <div v-if="hasError('email')" class="has-error">
                  <p>{{ getError("email") }}</p>
                </div>
              </div>

              <div class="text-center">
                    <button :disabled="loading" @click="submit" class="btn_1 full-width">
                        <span v-if="loading"><i class="mdi mdi-spin mdi-loading"></i> Processing</span>
                        <span v-else>Submit</span>
                    </button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import Validation from "../../mixins/validation";

export default {
  name: "Forgot Password",
  mixins: [Validation],
  data() {
    return {
    loading: false,
      email_sent: false,
      data: {
        email: null,
      },
    };
  },
  methods: {
    openForgotModal() {
      this.$modal.show("forgotModal");
    },
    submit() {
        this.loading = true;

        axios.post(route('customer.password.email'), this.data)
        .then(resp => {
            this.email_sent = true;
            this.$toast.open({
                message: 'The password reset link has been sent!',
                type: 'success'
            })
        })
        .catch(err => {
            const errors = err.response.data.errors;

            if(errors) {
                this.errors = errors;
            }

            this.$toast.open({
                message: 'Unable to send the password reset link',
                type: 'error',
            })
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