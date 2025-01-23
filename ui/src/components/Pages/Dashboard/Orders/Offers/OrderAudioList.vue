<template>
  <div class="w-100">
    <div class="w-100 d-flex justify-content-between align-items-center py-2">
      <v-card-title class="p-0">Аудіо</v-card-title>

      <AddRecordButton
          title="Додати варіант"
          @funcClose="toggleOfferForm"
      />

      <v-dialog
          v-model="showAddForm"
          max-width="600px"
      >
        <v-card>
          <HeaderForNewItem
              title="Новий запис"
              @funcClose="showAddForm = false"
          />
          <v-card-text class="px-3">
            <v-row align="center">
              <v-col cols="12" sm="9" class="mb-0 d-flex justify-content-between align-items-center">
                <SoundRecorder @sound-recorded="getSound" />
              </v-col>
              <v-col cols="12" sm="3" class="mb-0 d-flex justify-content-between align-items-center ps-2">
                <v-btn
                    class="my-v-btn-send"
                    color="success"
                    @click="saveSound"
                    :disabled="!getAudioBlobUrl"
                    :loading="this.recordFileSource && isShowSpinner"
                >
                    Відправити
                    <template v-slot:loader>
                      <v-progress-linear color="green" indeterminate></v-progress-linear>
                    </template>
                </v-btn>
              </v-col>
            </v-row>
            <hr />
            <v-row align="center">
              <v-col cols="12" class="mb-0 d-flex justify-content-between align-items-center">
                <SoundUpload :fnUploadFile="uploadFile" :uploadFileSource="uploadFileSource" />
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>

      </v-dialog>
    </div>

    <div class="w-100 mt-3">
      <OrderAudio
          v-for="(audio, i) in audious"
          :item="audio"
          :remove-audio="removeAudio"
          :key="'order-audio-item' + i"
      />
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import SoundRecorder from "@/components/Pages/Dashboard/Orders/Offers/SoundRecorder.vue";
import HeaderForNewItem from "@/components/Pages/Dashboard/Orders/Offers/Templates/HeaderForNewItem.vue";
import AddRecordButton from "@/components/Pages/Dashboard/Orders/Offers/Templates/AddRecordButton.vue";
import Offer from "@/components/Pages/Dashboard/Orders/Offers/Offer.vue";
import SoundUpload from "@/components/Pages/Dashboard/Orders/Offers/SoundUpload.vue";
import OrderAudio from "@/components/Pages/Dashboard/Orders/Offers/OrderAudio.vue";
import requestMethods from "@/mixin/requestMethods";


export default {
  name: "OrderAudioList",
  mixins: [requestMethods],
  components: {
    Offer,
    AddRecordButton,
    HeaderForNewItem,
    SoundRecorder,
    SoundUpload,
    OrderAudio
  },
  props: {
    callback: { //getOrderAudious
      type: Function,
      default: () => {
      }
    }
  },
  data() {
    return {
      showAddForm: false,
      audioBlobUrl: '',
      uploadFileSource: false,
      recordFileSource: false
    }
  },

  computed: {
    ...mapGetters({
      audious: 'OrderAudiousModule/getAudious',
      allUsers: 'ClientsModule/getAllUsers',
      order: 'OrderModule/getOrder',
      isShowSpinner: "SpinnerModule/isShowSpinner"
    }),
    getAudioBlobUrl() {
      return this.audioBlobUrl;
    },

  },

  methods: {
    ...mapActions({
      setAudious: 'OrderAudiousModule/setAudious',
      incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
      decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
    }),
    toggleOfferForm() {
      this.showAddForm = !this.showAddForm
    },
    uploadFile(source) {
      this.incrementSpinnerCounter()
      this.uploadFileSource = true
      this.sendRequest(source)
    },
    sendRequest(source) {
      const formData = new FormData();
      formData.append('source', source, 'audio.mp3');
      formData.append('order_id', this.order.id);
      formData.append('client_id', this.order.client_id);

      this.axios.post('order-audio/create', formData)
          .then(response => {
            let message = response.data.message || "Success";
            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
          })
          .then(() => {
            this.toggleOfferForm()
            this.callback()
          })
          .finally(() => {
            this.decrementSpinnerCounter()
            this.eventHub.$emit("resetSoundRecorder");
            this.uploadFileSource = false
            this.recordFileSource = false
          })
          .catch(error => {
            let message = error.message || "Щось пішло не так :/";
            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
          })
    },

    removeAudio(audio) {
      this.axios
          .post(`order-audio/${audio.id}`)
          .then(response => {
            let message = response.data.message || "Success";
            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
          })
          .then(() => {
            this.callback()
          })
          .catch(error => {
            let message = error.message || "Щось пішло не так :/";
            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
          })
    },

    async saveSound() {
      this.incrementSpinnerCounter()
      this.recordFileSource = true
      await fetch(this.getAudioBlobUrl)
          .then(response => response.blob())
          .then(response => {
            this.sendRequest(response);
          });
      this.audioBlobUrl = '';
    },

    getSound(audioBlobUrl) {
      this.audioBlobUrl = audioBlobUrl;
    },
  }
}
</script>

<style scoped>

  /deep/ .ar-player {
    padding-bottom: 5px;
  }

  /deep/ .ar-icon__lg {
    line-height: 33px;
  }

  .my-v-btn-send {
    padding: 0 8px!important;
  }

  /deep/ .ar-player-actions {
    width: auto!important;
  }

</style>