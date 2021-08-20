<template>
  <div class="row no-gutters">
    <div class="col-lg-6 pr-lg-1">
      <button @click="authenticate('facebook')" class="social_bt facebook">
        Sign in with Facebook
      </button>
    </div>
    <div class="col-lg-6 pl-lg-1">
      <button @click="authenticate('google')" class="social_bt google">
        Sign in with Google
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "SocialAuth",
  props: ['redirect'],
  methods: {
    authenticate(provider) {
      this.$auth
        .authenticate(provider)
        .then((resp) => {
          console.log(resp);
          this.getToken(provider, resp);
        })
        .catch((err) => {
          console.error(err);
          this.$toast.open({
            message: `Unable to login with ${provider}`,
            type: "error",
          });
        });
    },
    getToken(provider, response) {
      axios
        .post(route("customer.social.auth", { provider }), response)
        .then((resp) => {
          console.log(resp);
          this.$toast.open({
            message: `Successfully logged in with ${provider.toUpperCase()}`,
            type: "success",
          });

          if (this.redirect) {
            window.location = route("customer.dashboard");
          } else {
            let token = resp.data.token;
            this.$store.commit("authenticate", resp.data.user);

            if (token) {
              $('meta[name="csrf-token"]').attr("content", token);
              window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
            }
          }
        })
        .catch((err) => console.error(err));
    },
  },
};
</script>

<style>
</style>