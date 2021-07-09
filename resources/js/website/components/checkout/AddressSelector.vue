<template>
  <div>
      <loading v-if="loading"></loading>
      <single-address v-else-if="defaultAddress" :address="defaultAddress" :readonly="true"></single-address>
      <div v-else>
          <p class="text-muted">No addresses found. <a :href="addAddressUrl" class="btn btn-link">Add new</a></p>
          
      </div>
      <div class="mt-3">
          <button class="btn_1" @click="showAddresses">Change address</button>

          <modal name="addressSelector" :adaptive="true" height="auto" :scrollable="true">
              <div class="p-4">
                  <div class="header">
                    <h4>Select an address</h4>
                  </div>
                  
                  <div class="mt-3">
                      <div v-if="addresses && addresses.length">
                          <div class="mb-2" v-for="address in addresses" :key="address.id" @click="chooseAddress(address)">
                            <single-address :address="address" :readonly="true"></single-address>
                          </div>
                      </div>
                  </div>
              </div>
          </modal>
      </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import SingleAddress from '../customer/addresses/SingleAddress.vue'
import Loading from '../Loading.vue'

export default {
    name: 'AddressSelector',
    data() {
        return {
            loading: true,
            addresses: [],
            selected: null,
        }
    },
    components: {
        SingleAddress,
        Loading
    },
    computed:{
        ...mapGetters({
            auth: 'authenticated',
            user: 'authenticatedUser',
        }),
        defaultAddress() {
            if(!_.isEmpty(this.addresses)) {
                const address = this.addresses.find(address => address.is_default === 1)

                if(this.selected) {
                    return this.selected;
                } else if(address) {
                    return address;
                } else {
                    return this.addresses[0]
                }
            }
        },
        addAddressUrl() {
            return route('customer.address.index')
        }
    },
    methods: {
        fetchUserAddresses() {
            this.loading = true;
            axios.get(route('customer.address.index'))
            .then(resp => {
                this.addresses = resp.data.data
                this.updateAddress()
            })
            .catch(err => {
                console.error(err);
                this.$toast.open({
                    message: 'Unable to fetch the addresses. Try again later',
                    type: 'error'
                })
            })
            .finally(() => this.loading = false)
        },
        showAddresses() {
            if(!_.isEmpty(this.addresses) && this.addresses.length > 1) {
                this.$modal.show('addressSelector')
            }
        },
        chooseAddress(address) {
            this.selected = address;
            this.$modal.hide('addressSelector')
            this.updateAddress()
        },
        updateAddress() {
            this.$emit('selectAddress', this.defaultAddress)
        }
    },
    created() {
        if(this.auth) {
            this.fetchUserAddresses()
        }
    }
}
</script>

<style>

</style>