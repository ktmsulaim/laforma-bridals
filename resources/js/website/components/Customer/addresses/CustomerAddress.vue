<template>
    <div>
    <loading v-if="loading"></loading>
    <div v-else-if="addresses && addresses.length" class="row">
        <div class="col-12 text-right mb-2">
            <button @click="openModal('create')" class="button-text"><span class="mdi mdi-plus"></span> Add new</button>    
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" v-for="address in addresses" :key="address.id">
            <single-address :readonly="false" @editAddress="editAddress" @deleted="deleteAddress" :address="address"></single-address>
        </div>
    </div>
    <div class="text-center" v-else>
        <p>No address found!</p>
        <button @click="openModal('create')" class="button-text"><span class="mdi mdi-plus"></span> Add new</button>
    </div>
        <address-form @saved="updateAddress" :mode="edit.status ? 'edit' : 'create'" :address="edit.data" @closeModal="clearEdit"></address-form>
    </div>
</template>

<script>
import Loading from "../../Loading.vue";
import AddressForm from './AddressForm.vue'
import SingleAddress from './SingleAddress.vue'

export default {
  name: "CustomerAddress",
  components: {
    Loading,
    AddressForm,
    SingleAddress
  },
  data() {
    return {
      addresses: [],
      loading: true,
      edit: {
          status: false,
          data: null,
      }
    };
  },
  methods: {
    fetchAddresses() {
    this.loading = true;
      axios
        .get(route("customer.address.index"))
        .then((resp) => {
            this.addresses = resp.data.data;
        })
        .catch((err) =>
          this.$toast.open({
            message: "Unable to fetch the addresses",
            type: "error",
          })
        )
        .finally(() => (this.loading = false));
    },
    openModal(mode = 'create') {
        if(mode == 'create') {
            this.edit.status = false;
            this.edit.data = null;
        } else {
            this.edit.status = true;
        }

        this.$modal.show('addressForm')
    },
    editAddress(value) {
        this.edit.data = value;
        this.openModal('edit');
    },
    updateAddress(value) {
        if(!_.isEmpty(value)) {
            const mode = value.mode;
            const address = value.data;

            if(address.is_default) {
                this.fetchAddresses();
            }

            if(mode == 'edit') {
                const oldAddress = this.addresses.find(old => old.id == address.id)
                const index = this.addresses.indexOf(oldAddress)

                if(index != -1) {
                    this.addresses.splice(index, 1, address)
                }
            } else {
                this.addresses.push(address);
            }
        }
    },
    deleteAddress(address) {
        const index = this.addresses.indexOf(address)

        if(index != -1) {
            this.addresses.splice(index, 1)
        }
    },
    clearEdit() {
        this.edit.status = false;
        this.edit.data = null;
    }
  },
  created() {
    this.fetchAddresses();
  },
};
</script>

<style>
</style>