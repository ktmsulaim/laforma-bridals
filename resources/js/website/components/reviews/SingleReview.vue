<template>
  <div class="review_content">
    <div class="clearfix add_bottom_10">
        <span class="rating">
            <star-rating :increment=".5" :rating="review.rating" :read-only="true" :star-size="20"></star-rating>
        </span>
        <em>Published {{ review.published }}</em>
    </div>
    <h4>"{{ review.title }}"</h4>
    <p>
        {{ review.review }}
    </p>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating'
export default {
    name: 'SingleReview',
    props: ['review'],
    components: {
        StarRating,
    }
}
</script>

<style>

</style>