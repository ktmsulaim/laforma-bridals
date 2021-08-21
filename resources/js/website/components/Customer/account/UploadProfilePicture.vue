<template>
  <div id="profile-pic-uploader">
      <div class="profile-pic">
          <img :src="image" alt="">
      </div>
        <div class="uploader">
            <input type="file" id="file" accept="image/png, image/jpeg" @change="handleFile">
            <button :disabled="loading || !file.binary" class="btn btn-default" @click="changePhoto">
                <span v-if="loading">
                    <i class="mdi mdi-loading mdi-spin"></i>
                </span>
                <span v-else>Change</span>
            </button>
        </div>
  </div>
</template>

<script>
export default {
    name: 'UploadProfilePicture',
    props: ['oldPhoto'],
    computed: {
        image() {
            return this.file.base64 ? this.file.base64 : this.oldPhoto;
        }
    },
    data() {
        return {
            file: {
                base64: null,
                binary: null,
            },
            loading: false,
        }
    },
    methods: {
        handleFile(e) {
            const file = e.target.files[0]

            if(file) {
                this.file.binary = file;

                const fileReader = new FileReader()
                fileReader.onload = (e) => {
                    this.file.base64 = e.target.result
                }
                fileReader.readAsDataURL(file)
            }
        },
        changePhoto(){
            if(this.file.binary) {
                this.loading = true;
                const form = new FormData()
                form.append('file', this.file.binary)

                axios.post(route('customer.account.photo'), form)
                .then(resp => this.$toast.open({
                    message: 'The photo has been uploaded',
                    type: 'success'
                }))
                .catch(err => {
                    let message = err.response.data.error;
                    const validation = err.response.data.errors.file[0];

                    if(validation) {
                        message = validation;
                    } else if(!message) {
                        message = "Unable to upload the photo";
                    }

                    this.$toast.open({
                        message,
                        type: 'error'
                    })
                })
                .finally(() => this.loading = false)
            }
        }
    }

}
</script>

<style>

</style>