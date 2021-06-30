export default {
    mounted() {
        this.$nextTick(() => {
            $('.prod_pics').owlCarousel({
                items: 1,
                loop: false,
                margin: 0,
                dots:true,
                lazyLoad:true,
                nav:false
            });
            
            // Image popups
            $('.magnific-gallery').each(function () {
                $(this).magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    preloader: true,
                    gallery: {
                        enabled: true
                    },
                    removalDelay: 500, //delay removal by X to allow out-animation
                    callbacks: {
                        beforeOpen: function () {
                            // just a hack that adds mfp-anim class to markup 
                            this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                            this.st.mainClass = this.st.el.attr('data-effect');
                        }
                    },
                    closeOnContentClick: true,
                    midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                });
            });
        })
    }
}