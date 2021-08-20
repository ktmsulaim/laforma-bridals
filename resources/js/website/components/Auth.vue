<template>
  <div :class="{'col-md-6 mx-auto': redirect}">
      <login :redirect="redirect" v-if="type == 'login'"></login>
      <register :redirect="redirect" v-else-if="type == 'register'"></register>
  </div>
</template>

<script>
import Login from './auth/Login.vue'
import Register from './auth/Register.vue'
export default {
    name: 'Auth',
    props: ['type', 'redirect'],
    components: {
        Login,
        Register
    }
}
</script>

<style>

</style>