<template>
    <v-row align="start">
      <v-col cols="12" md="7" class="justify-content-between align-items-center">
        <v-file-input
            label="Завантажте файл"
            small-chips
            accept=".mp3,audio/mpeg"
            @change="onFileChange"
            :rules="this.fileRules"
        ></v-file-input>
      </v-col>
      <v-col cols="12" md="5" class="justify-content-between align-items-center">
        <v-btn
            color="success"
            @click="send"
            :disabled="!selectedFile || !isValid || (this.uploadFileSource && isShowSpinner)"
            :loading="this.uploadFileSource && isShowSpinner"
        >
            Завантажити файл
            <template v-slot:loader>
              <v-progress-linear color="green" indeterminate></v-progress-linear>
            </template>
        </v-btn>
      </v-col>
    </v-row>
</template>

<script>

import {validationMixin} from "vuelidate";
import {mapGetters} from "vuex";

export default {
  mixins: [validationMixin],
  name: "SoundUpload",
  props: {
    fnUploadFile: {
      type: Function,
      default: () => {
      }
    },
    uploadFileSource: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      showSendButton: false,
      selectedFile: null,
      maxFileSize: 10485760,
      isValid: true,
      fileRules: [
        v => {
          if (!v) {
            return true;
          }

          if (v && v.size <= this.maxFileSize) {
            this.isValid = true;
            return this.isValid;
          }
          this.isValid = false;
          return this.showMaxSizeError()
        }
      ]
    }
  },
  computed: {
    ...mapGetters({
      isShowSpinner: "SpinnerModule/isShowSpinner"
    }),
  },
  methods: {
    showMaxSizeError() {
      return 'Файл перевищує ' + Math.round(this.maxFileSize/(1024*1024)) + 'MB'
    },
    send() {
      this.fnUploadFile(this.selectedFile)
    },
    onFileChange(file) {
      this.selectedFile = file;
    },
  },
}
</script>

<style scoped>
  /deep/ .v-messages.theme--light {
    min-height: auto;
  }

  /deep/ .v-text-field__details {
      min-height: auto;
  }
</style>