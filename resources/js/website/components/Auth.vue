<template>
  <div class="col-md-6 mx-auto">
      <login v-if="type == 'login'"></login>
      <register v-else-if="type == 'register'"></register>
  </div>
</template>

<script>
import Login from './auth/Login.vue'
import Register from './auth/Register.vue'
export default {
    name: 'Auth',
    props: ['type'],
    components: {
        Login,
        Register
    }
}
</script>

<style>

</style>