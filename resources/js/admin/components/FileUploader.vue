<template>
  <VueFileAgent 
    ref="vueFileAgent"
    :uploadUrl="uploadUrl" 
    v-model="files"
    :multiple="true"
    :accept="'image/*'"
    :maxSize="'5MB'"
    :maxFiles="14" 
    :auto="false"
    :meta="false"
    @select="filesSelected($event)"
    @beforedelete="onBeforeDelete($event)"
    @delete="fileDeleted($event)"
  ></VueFileAgent>
</template>

<script>
export default {
    name: 'FileUploader',
    data() {
        return {
            files: [],
            uploadUrl: route('admin.images.store'),
            fileRecordsForUpload: [],
            fileData: [],
            uploadHeaders: {
                'X-CSRF-TOKEN': token
            }
        }
    },
    methods: {
        uploadFiles: function () {
        this.$refs.vueFileAgent.upload(this.uploadUrl, this.uploadHeaders, this.fileRecordsForUpload);
        this.fileRecordsForUpload = [];
      },
      deleteUploadedFile: function (fileRecord) {
        this.$refs.vueFileAgent.deleteUpload(this.uploadUrl, this.uploadHeaders, fileRecord);
      },
      filesSelected: function (fileRecordsNewlySelected) {
        var validFileRecords = fileRecordsNewlySelected.filter((fileRecord) => !fileRecord.error);
        this.fileRecordsForUpload = this.fileRecordsForUpload.concat(validFileRecords);

        this.fileData = this.fileRecordsForUpload.map(file => file.file)

        this.uploadFiles()
      },
      onBeforeDelete: function (fileRecord) {
        var i = this.fileRecordsForUpload.indexOf(fileRecord);
        if (i !== -1) {
        // queued file, not yet uploaded. Just remove from the arrays
          this.fileRecordsForUpload.splice(i, 1);
          var k = this.files.indexOf(fileRecord);
          if (k !== -1) this.files.splice(k, 1);
        } else {
          if (confirm('Are you sure you want to delete?')) {
            this.$refs.vueFileAgent.deleteFileRecord(fileRecord); // will trigger 'delete' event
          }
        }
      },
      fileDeleted: function (fileRecord) {
        var i = this.fileRecordsForUpload.indexOf(fileRecord);
        if (i !== -1) {
          this.fileRecordsForUpload.splice(i, 1);
        } else {
          this.deleteUploadedFile(fileRecord);
        }
      },
      clearUploads() {
        this.fileRecordsForUpload = [];
        this.fileData = [];
        this.files = [];
      }
    }
}
</script>

<style>

</style>