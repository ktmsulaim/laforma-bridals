<template>
  <div>
      <div class="form-group">
          <star-rating :star-size="25" :increment=".5" v-model="data.rating" active-color="#fec348"></star-rating>
      </div>
      <div class="form-group" :class="{ 'is-invalid': hasError('name') }">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" v-model="data.name" :readonly="authenticated">
          
          <div v-if="hasError('name')" class="has-error">
            <p>{{ getError("name") }}</p>
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
                    <span v-if="captcha.loading" class="mdi mdi-loading mdi-spin"></span>
                    <img v-else-if="captcha.img" :src="captcha.img" alt="Captcha">
                </div>
                <div class="col" v-if="!captcha.loading">
                    <input type="text" class="form-control" v-model="data.captcha">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button :disabled="submit.loading" @click="submit" class="btn_1">Submit</button>
    </div>
  </div>
</template>

<script>
import ValidationMixin from '../../mixins/validation'

import StarRating from 'vue-star-rating'
import {mapGetters} from 'vuex'

export default {
    name: 'ReviewForm',
    props: ['product'],
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
            },
            data: {
                product_id: null,
                customer_id: null,
                name: null,
                title: null,
                review: null,
                rating: 0,
                captcha: null,
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
        submit() {

        }
    },
    created() {
        this.getCaptcha()

        if(this.product) {
            this.data.product_id = this.product;
        }

        if(this.authenticated && !this.isEmpty(this.authenticatedUser)) {
            this.data.customer_id = this.authenticatedUser.id;
            this.data.name = this.authenticatedUser.name;
        }
    }
}
</script>

<style>

</style>