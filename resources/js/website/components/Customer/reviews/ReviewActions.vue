<template>
  <div class="text-right mb-3">
      <button class="btn btn-default" style="margin-right: 5px" @click="openReviewModal">
          <div v-if="edit.loading">
              <i class="mdi mdi-spin mdi-loading"></i>
              <span style="margin-left: 3px">Processing</span>
          </div>
          <div v-else>
            <i class="mdi mdi-pencil"></i>
            Edit
          </div>
      </button>
      <button class="btn btn-danger" @click="destroyReview">
          <div v-if="destroy.loading">
              <i class="mdi mdi-spin mdi-loading"></i>
              <span style="margin-left: 3px">Processing</span>
          </div>
          <div v-else>
            <i class="mdi mdi-trash-can"></i>
            Delete
          </div>
      </button>

      <modal name="reviewModal" :adaptive="true" height="auto" :scrollable="true">
        <div class="review-form">
            <div class="form-title">
                Edit review
            </div>
            <div class="form-body">
                <review-form @save="closeReviewModal" :product="review.product_id" :old="review"></review-form>
            </div>
        </div>
    </modal>
  </div>
</template>

<script>
import ReviewForm from '../../reviews/ReviewForm.vue'
export default {
    name: 'ReviewActions',
    props: ['review'],
    components:{
        ReviewForm,
    },
    data() {
        return {
            edit: {
                loading: false,
            },
            destroy: {
                loading: false,
            }
        }
    },
    methods: {
        closeReviewModal() {
            this.$modal.hide('reviewModal')
            window.location.reload()
        },
        openReviewModal() {
            this.$modal.show('reviewModal')
        },
        destroyReview() {
            if(this.review) {
                this.$swal({
                    titleText: 'Are you sure?',
                    icon: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    confirmButtonColor: '#ff5b5b',
                })
                .then(response => {
                    if(response.isConfirmed) {
                        axios.delete(route('customer.reviews.destroy', {review: this.review.id}))
                        .then(resp => {
                            this.$toast.open({
                                message: 'The review has been deleted',
                                type: 'error'
                            })
                            window.location = route('customer.reviews.index')
                        })
                        .catch(err => {
                            this.$swal('Unable to delete the review', '', 'error')
                        })
                    }
                })
                .catch(err => {
                    this.$swal('Sorry! Unable to delete the review. Try again later', '', 'error')
                })
            }
        }
    }
}
</script>

<style>

</style>