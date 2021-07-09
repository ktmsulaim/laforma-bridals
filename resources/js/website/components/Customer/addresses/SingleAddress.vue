<template>
  <div class="single-address">
      <div class="head">
        {{ address.full_name }}
      </div>
      <div class="body">
        <p class="address_line">{{ address.address_line1 }}</p>
        <p class="address_line">{{ address.address_line2 }}</p>
        <p>{{ address.city }}, {{ address.district }}, {{ address.state }}, {{ address.pincode }}</p>
        <p>{{ address.phone }}</p>
        <p>{{ address.landmark }}</p>
      </div>
      <div v-if="!readonly" class="footer">
        <div class="part-1">
          <div class="default" v-if="address.is_default">
            <span class="label label-info">Default</span>
          </div>
        </div>
        <div class="part-2">
          <button @click="edit" class="button-text-1">
            <span class="mdi mdi-pencil-box-outline"></span>
            <span>Edit</span>
          </button>
          <button @click="remove" class="button-text-1 delete ml-2">
            <span class="mdi mdi-trash-can"></span>
            <span>Delete</span>
          </button>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  name: 'SingleAddress',
  props: ['address', 'readonly'],
  methods: {
    edit() {
      this.$emit('editAddress', this.address);
    },
    remove() {
      this.$swal({
          titleText: 'Are you sure?',
          icon: 'warning',
          allowOutsideClick: false,
          showCancelButton: true,
          confirmButtonText: 'Proceed',
          confirmButtonColor: '#ff5b5b',
      })
      .then(result => {
          if(result.isConfirmed) {
              axios.delete(route('customer.address.destroy', this.address.id))
              .then(resp => {
                  this.$swal('The address has been deleted', '', 'success')
                  this.$emit('deleted', this.address);
              })
              .catch(error => {
                  this.$swal('Sorry! Unable to delete the address', '', 'error')
              })
          }
      })
      .catch(error => {
          console.error(error);
          this.$swal('Sorry! Unable to delete the address. Try again later', '', 'error')
      })
    }
  }
}
</script>

<style>

</style>