<template>
    <div ref="reviewsTop">
        <Loading v-if="loading" />
        <div v-else-if="hasReviews" class="row justify-content-between">
            <div v-for="review in reviews" :key="review.id" class="col-lg-5">
                <review
                    :review="review"
                ></review>
            </div>

            <div class="col-12">
                <div class="pagination__wrapper">
                    <pagination
                    :data="reviewsData"
                    @pagination-change-page="fetchReviews"
                    align="center"
                    ></pagination>
                </div>
            </div>
        </div>
        <div v-else class="row">
            <div class="col-lg-6 mx-auto">
                <review-form :product="productId"></review-form>
            </div>
        </div>
        <!-- /row -->
        <div v-if="hasReviews">
            <p class="text-right">
                <button class="btn_1" @click="openReviewModal">Leave a review</button>
            </p>

            <modal name="reviewModal" :adaptive="true" height="auto" :scrollable="true">
                <div class="review-form">
                    <div class="form-title">
                        Write a review
                    </div>
                    <div class="form-body">
                        <review-form @save="closeReviewModal" :product="productId"></review-form>
                    </div>
                </div>
            </modal>
        </div>
    </div>
</template>

<script>
import Review from "./SingleReview.vue";
import ReviewForm from "./ReviewForm.vue";
import Loading from "../Loading.vue";

import { mapGetters } from "vuex";
export default {
    name: "Reviews",
    props: ["productId"],
    components: {
        Loading,
        Review,
        ReviewForm
    },
    data() {
        return {
            loading: false
        };
    },
    computed: {
        ...mapGetters({
            reviewsData: "getReviews"
        }),
        hasReviews() {
            return this.reviews && !this.isEmpty(this.reviews);
        },
        reviews() {
            return this.reviewsData.data;
        }
    },
    methods: {
        fetchReviews(page = 1) {
            this.loading = true;
            axios
                .get(
                    route("reviews.get", {
                        page,
                        product: this.productId,
                    })
                )
                .then(resp => {
                    this.$store.commit('setReviews', resp.data)
                })
                .catch(err => {
                    let message = err.response.data.error;

                    if (!message) {
                        message = "Unable to fetch reviews";
                    }
                    this.$toast.open({
                        message,
                        type: "error"
                    });
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        openReviewModal() {
            this.$modal.show('reviewModal')
        },
        closeReviewModal() {
            this.$nextTick(() => {
                const el = this.$refs.reviewsTop

                if(el) {
                    el.scrollIntoView({behavior: 'smooth'})
                }

                this.$modal.hide('reviewModal')
                this.fetchReviews()
            })
        }
    },
    created() {
        this.fetchReviews()
    }
};
</script>

<style></style>
