<template>
    <div>
        <div v-if="loading">
            <vue-skeleton-loader
                v-if="type == 'image'"
                type="circle"
                :width="40"
                :height="40"
                animation="fade"
            />
            <vue-skeleton-loader
                v-else-if="type == 'title'"
                type="rect"
                :width="200"
                :height="20"
                animation="fade"
            />
            <vue-skeleton-loader
                v-else-if="type == 'subtitle'"
                type="rect"
                :width="100"
                :height="10"
                animation="fade"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "Card",
    props: ["type"],
    data() {
        return {
            loading: true
        };
    },
    computed: {}
};
</script>

<style></style>
