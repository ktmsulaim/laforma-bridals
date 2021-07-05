<template>
  <modal name="addressForm" :adaptive="true" height="auto" :scrollable="true" :clickToClose="false" @closed="clearInput">
      <div class="p-4">
          <div class="head">
            <h4>{{ modeLabel }} address</h4>
            <span class="mdi mdi-close-thick" @click="$modal.hide('addressForm')"></span>
          </div>
          <form @submit.prevent="submit" method="POST">
          <div class="form-group" :class="{ 'is-invalid': hasError('full_name') }">
              <label for="full_name">Full name <span class="text-danger">*</span></label>
              <input type="text" id="full_name" v-model="data.full_name" class="form-control">
              <div v-if="hasError('full_name')" class="has-error">
                    <p>{{ getError("full_name") }}</p>
                </div>
          </div>
          <div class="form-group" :class="{ 'is-invalid': hasError('address_line1') }">
              <label for="address_line1">Address line 1 <span class="text-danger">*</span></label>
              <input type="text" id="address_line1" v-model="data.address_line1" class="form-control">
              <div v-if="hasError('address_line1')" class="has-error">
                    <p>{{ getError("address_line1") }}</p>
                </div>
          </div>
          <div class="form-group">
              <label for="address_line2">Address line 2</label>
              <input type="text" id="address_line2" v-model="data.address_line2" class="form-control">
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group" :class="{ 'is-invalid': hasError('city') }">
                    <label for="city">City <span class="text-danger">*</span></label>
                    <input type="text" id="city" v-model="data.city" class="form-control">
                    <div v-if="hasError('city')" class="has-error">
                        <p>{{ getError("city") }}</p>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group" :class="{ 'is-invalid': hasError('district') }">
                    <label for="district">District <span class="text-danger">*</span></label>
                    <input type="text" id="district" v-model="data.district" class="form-control">
                    <div v-if="hasError('district')" class="has-error">
                        <p>{{ getError("district") }}</p>
                    </div>
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group" :class="{ 'is-invalid': hasError('state') }">
                    <label for="state">State <span class="text-danger">*</span></label>
                    <input type="text" id="state" v-model="data.state" class="form-control">
                    <div v-if="hasError('state')" class="has-error">
                        <p>{{ getError("state") }}</p>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group" :class="{ 'is-invalid': hasError('phone') }">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="tel" id="phone" v-model="data.phone" class="form-control">
                    <div v-if="hasError('phone')" class="has-error">
                        <p>{{ getError("phone") }}</p>
                    </div>
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group" :class="{ 'is-invalid': hasError('pincode') }">
                    <label for="pincode">Pincode <span class="text-danger">*</span></label>
                    <input type="number" id="pincode" v-model="data.pincode" class="form-control">
                    <div v-if="hasError('pincode')" class="has-error">
                        <p>{{ getError("pincode") }}</p>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="landmark">Landmark</label>
                    <input type="text" id="landmark" v-model="data.landmark" class="form-control">
                </div>
              </div>
          </div>
          <div class="form-group">
              <label for="is_default">
                  <input type="checkbox" id="is_default" v-model="data.is_default"> Default
              </label>
          </div>
          <div class="mt-2">
              <button :disabled="loading" class="btn_1">
                  <span v-if="loading">
                      <span class="mdi mdi-loading mdi-spin"></span> Saving
                  </span>
                  <span v-else>Save</span>
              </button>
          </div>
          </form>
      </div>
  </modal>
</template>

<script>
import Validation from '../../../mixins/validation'
export default {
    name: 'AddressForm',
    props: ['address', 'mode'],
    mixins: [Validation],
    data() {
        return {
            loading: false,
            data: {
                full_name: null,
                address_line1: null,
                address_line2: null,
                city: null,
                district: null,
                state: null,
                phone: null,
                pincode: null,
                landmark: null,
                is_default: 1,
            },
            newData: null,
        }
    },
    computed:{
        modeLabel() {
            if(this.mode == 'create') {
                return 'Add';
            } else {
                return 'Edit';
            }
        }
    },
    methods: {
        submit() {
            let url, method;

            if(this.mode == 'edit') {
                url = route('customer.address.update', {address: this.address.id})
                method = 'PATCH'    
            } else {
                url = route('customer.address.store')
                method = 'POST';
                
            }

            this.loading = true;
            axios({
                    url,
                    method,
                    data: this.data
                })
            .then(resp => {
                this.$toast.open({
                message: 'The address has been saved',
                type: 'success'
                })

                this.newData = resp.data.data;
                this.updateAddress()
                this.$modal.hide('addressForm')
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
        },
        updateAddress() {
            this.$emit('saved', {mode: this.mode, data: this.newData})
        },
        clearInput() {
            this.data = {
                full_name: null,
                address_line1: null,
                address_line2: null,
                city: null,
                district: null,
                state: null,
                phone: null,
                pincode: null,
                landmark: null,
                is_default: 1,
            };

            this.$emit('closeModal', true);
        }
    },
    watch:{
        address(newVal, oldVal) {
            if(!_.isEmpty(newVal)) {
                if(this.mode == 'edit') {
                    this.data.full_name = newVal.full_name
                    this.data.address_line1 = newVal.address_line1
                    this.data.address_line2 = newVal.address_line2
                    this.data.city = newVal.city
                    this.data.district = newVal.district
                    this.data.state = newVal.state
                    this.data.phone = newVal.phone
                    this.data.pincode = newVal.pincode
                    this.data.landmark = newVal.landmark
                    this.data.is_default = newVal.is_default
                }
            }
        }
    }
}
</script>

<style scoped>
.head {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>