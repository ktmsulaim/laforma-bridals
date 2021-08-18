<template>
   <div class="card card-inverse text-white" :class="{'selected': selected, 'hover': edit.status}" @click="select" :style="{backgroundImage: `url(${image.path})`}">
        <!-- <img class="card-img img-fluid" :src="image.path" alt="Image"> -->
        <div class="card-img-overlay">
            <h4 class="card-title text-white">{{ image.filename }}</h4>
            <p class="card-text">{{ image.size }}</p>
            <p class="card-text">
                <small class="">{{ image.created_at }}</small>
            </p>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
    name: 'SingleImage',
    props: ['image'],
    computed: {
        ...mapState({
            edit: state => state.Media.edit
        }),
        selected() {
            return this.edit.selected.includes(this.image.id);
        },
    },
    methods: {
        select() {
            if(this.edit.status) {
                this.$store.commit('selectImage', this.image.id)
            }
        },
    },
    mounted() {
        this.$nextTick(() => {
            $(".image-popup").magnificPopup({ type: "image", closeOnContentClick: !0, mainClass: "mfp-fade", gallery: { enabled: !0, navigateByImgClick: !0, preload: [0, 1] } });
        })
    }
}
</script>

<style scoped>
    .card {
        height: 180px;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        margin-bottom: 15px;
        transition: all .3s;
    }
    
    .card-img-overlay {
        background: rgba(0,0,0,0.5);
        border-radius: 8px;
    }

    .selected {
        border: 3px solid #71b6f9;
    }

    .hover {
        cursor: pointer;
    }
</style>