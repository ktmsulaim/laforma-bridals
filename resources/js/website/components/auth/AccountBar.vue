<template>
  <div class="dropdown dropdown-access" :class="{'authenticated': authenticated}">
    <a href="javascript:void(0)" class="access_link"><span>Account</span></a>
    <div class="dropdown-menu">	
            <ul v-if="authenticated">
                <li>
                    <a :href="dashboardUrl"><i class="mdi mdi-home-outline"></i>Dashboard</a>
                </li>
                <li>
                    <a :href="appointmentsUrl"><i class="mdi mdi-calendar-check"></i>My bookings</a>
                </li>
                <li>
                    <a :href="ordersUrl"><i class="ti-package"></i>My Orders</a>
                </li>
                <li>
                    <a :href="accountUrl"><i class="ti-user"></i>My Profile</a>
                </li>
                <li>
                    <a href="javascript:void(0)" :disabled="signoutLoading" @click="signout">
                        <div v-if="signoutLoading"><i class="mdi mdi-logout"></i> Signing out...</div>
                        <div v-else><i class="mdi mdi-logout"></i> Sign out</div>
                    </a>
                </li>
            </ul>
            <a v-else :href="signInUrl" class="btn_1">Sign In or Sign Up</a>
    </div>
</div>
<!-- /dropdown-access-->
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'AccountBar',
    props: ['user'],
    data() {
        return {
            signoutLoading: false,
        }
    },
    computed:{
        ...mapGetters({
            authenticated: 'authenticated',
            authenticatedUser: 'authenticatedUser'
        }),
        dashboardUrl() {
            return route('customer.dashboard')
        },
        ordersUrl() {
            return route('customer.orders');
        },
        accountUrl() {
            return route('customer.account');
        },
        appointmentsUrl() {
            return route('customer.appointments');
        },
        signInUrl() {
            return route("customer.login");
        },
        signOutUrl() {
            return route('customer.logout')
        }
    },
    methods: {
        signout() {
            this.signoutLoading = true;
            axios.post(route('customer.logout.post'))
            .then(resp => {
                window.location = route('customer.login')
            })
            .catch(err => this.$toast.open({
                message: 'Unable to log out the user',
                type: 'error'
            }))
            .finally(() => this.signoutLoading = false)
        }
    },
    created() {
        if(this.user) {
            this.$store.commit('authenticate', this.user);
        }
    }
}
</script>

<style>

</style>