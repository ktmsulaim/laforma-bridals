<template>
  <div>
      <div class="form-group">
          <star-rating :star-size="25" :increment=".5" v-model="data.rating" active-color="#fec348"></star-rating>
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('reviewer_name') }">
          <label for="reviewer_name">Name</label>
          <input type="text" class="form-control" id="reviewer_name" v-model="data.reviewer_name" :readonly="authenticated">
          
          <div v-if="hasError('reviewer_name')" class="has-error">
            <p>{{ getError("reviewer_name") }}</p>
          </div>
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('title') }">
          <label for="title">Title</label>
          <input type="text" class="form-control" id="title" v-model="data.title">

          <div v-if="hasError('title')" class="has-error">
            <p>{{ getError("title") }}</p>
          </div>
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('review') }">
          <label for="review">Review</label>
          <textarea id="review" cols="30" rows="5" class="form-control" v-model="data.review"></textarea>

          <div v-if="hasError('review')" class="has-error">
            <p>{{ getError("review") }}</p>
          </div>
      </div>
    <div class="form-group" :class="{ 'is-invalid': hasError('captcha') }">
        <label for="captcha">Captcha</label>
        <div>
            <div class="row">
                <div class="col">
                    <span v-if="captcha.loading" class="mdi mdi-loading mdi-spin loading-inline"></span>
                    <div v-else-if="captcha.img">
                        <img :src="captcha.img" alt="Captcha">
                        <span @click="getCaptcha" id="refresh-captcha" class="mdi mdi-refresh"></span>
                    </div>

                </div>
                <div class="col" v-if="!captcha.loading">
                    <input type="text" class="form-control" v-model="captcha.answer">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button :disabled="submit.loading" @click="validateCaptcha" class="btn_1">
            <span v-if="submit.loading">
                <i class="mdi mdi-spin mdi-loading"></i>
                Processing
            </span> 
            <span v-else>Submit</span>
        </button>
    </div>
  </div>
</template>

<script>
import ValidationMixin from '../../mixins/validation'

import StarRating from 'vue-star-rating'
import {mapGetters} from 'vuex'

export default {
    name: 'ReviewForm',
    props: ['product', 'old'],
    mixins: [ValidationMixin],
    components: {
        StarRating
    },
    data() {
        return {
            submit: {
                loading: false,
            },
            captcha: {
                key: null,
                img: null,
                loading: true,
                answer: null,
                validate: false,
            },
            data: {
                product_id: null,
                customer_id: null,
                reviewer_name: null,
                title: null,
                review: null,
                rating: 1,
                status: 0,
            },
            errors: [],
        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'authenticated',
            authenticatedUser: 'authenticatedUser'
        }),
    },
    methods: {
        getCaptcha() {
            this.captcha.loading = true;

            axios.get(`/captcha/api/math`)
            .then(resp => {
                let data = resp.data

                this.captcha.key = data.key
                this.captcha.img = data.img
            })
            .catch(err => {
                this.$toast.open({
                    message: 'Unable to load captcha',
                    type: 'error'
                })

                this.errors = err.response.data.errors;
            })
            .finally(() => this.captcha.loading = false)
        },
        validateCaptcha() {
            if(this.captcha.key && this.captcha.answer) {
                this.submit.loading = true;

               axios.post(route('captcha.validate'), {
                    captcha: this.captcha.answer,
                    key: this.captcha.key,
                })
                .then(resp => {
                    this.captcha.validate = true;
                    this.submitForm()
                })
                .catch(err => {
                    let message = err.response.data.error;

                    if(!message) {
                        message = "Unable to validate captcha. Try again later";
                    }

                    this.$toast.open({
                        message,
                        type: 'error'
                    })

                    this.resetCaptcha()
                })
                .finally(() => {
                    this.submit.loading = false;
                })
            }
        },
        resetCaptcha() {
            this.captcha.answer = null;
            this.getCaptcha()
        },
       submitForm() {
           if(this.captcha.validate) {
               let url;
               if(this.old) {
                   url = route('customer.reviews.update', {review: this.old.id})
                   this.data._method = 'PATCH';
               } else {
                   url = route('reviews.store')
               }
               axios.post(url, this.data)
               .then(resp => {
                   this.$toast.open({
                       message: `The review has been ${this.old ? 'saved' : 'posted'}`,
                       type: 'success'
                   })
                   
                   if(!this.old) {
                       this.$store.commit('addToReviews', resp.data)
                   }

                   this.$emit('save')
               })
               .catch(err => {
                   const errors = err.response.data.errors;
                   this.errors = errors;

                   this.$toast.open({
                       message: `Unable to ${this.old ? 'save' : 'post'} the review`,
                       type: 'error'
                   })

                   this.resetCaptcha()
               })
               .finally(() => {
                   if(this.submit.loading) {
                       this.submit.loading = false;
                   }
               })
           }
        }
    },
    created() {
        this.getCaptcha()

        if(this.product) {
            this.data.product_id = this.product;
        }

        if(this.authenticated && !this.isEmpty(this.authenticatedUser)) {
            this.data.customer_id = this.authenticatedUser.id;
            this.data.reviewer_name = this.authenticatedUser.name;
            this.data.status = 1;
        }

        if(this.old) {
            this.data = {
                product_id: this.old.product_id,
                customer_id: this.old.customer_id,
                reviewer_name: this.old.reviewer_name,
                title: this.old.title,
                review: this.old.review,
                rating: this.old.rating,
                status: this.old.status,
            }
        }
    }
}
</script>

<style>
    
</style>