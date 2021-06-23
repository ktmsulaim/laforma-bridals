export default {
    methods: {
        updateSlug(value, target) {
            if(this.data[value]) {
                this.data[target] = this.slugify(this.data[value]);
            } else {
                this.data[target] = this.data[value];
            }
        }
    }
}