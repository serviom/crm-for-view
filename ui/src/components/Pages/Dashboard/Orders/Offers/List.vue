<template>
  <div class="w-100">
    <div class="w-100 d-flex justify-content-between align-items-center py-2">
      <v-card-title class="p-0">Запропоновані варіанти</v-card-title>

      <AddRecordButton
          title="Додати варіант"
          @funcClose="toggleOfferForm"
      />

      <v-dialog
          v-model="showOfferForm"
          max-width="600px"
      >
        <v-card>
          <HeaderForNewItem
              title="Новий варіант"
              @funcClose="showOfferForm = false"
          />
          <v-card-text class="px-5">
            <v-row align="center">
              <v-col cols="12" class="mb-0 pb-0 d-flex justify-content-between align-items-center">
                <v-text-field
                    :error="newOfferLinkError.length>0"
                    :error-messages="newOfferLinkError"
                    @focus="newOfferLinkError = ''"
                    class="mt-3"
                    dense
                    v-model="newOfferLink"
                    label="Посилання"
                ></v-text-field>
                <v-btn
                    class="ml-3"
                    style="margin-top:-10px"
                    color="success"
                    @click="addOffer"
                >Додати
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>

    <div class="w-100 mt-3">
      <offer
          v-for="(offer, i) in offers"
          :key="i"
          :item="offer"
          :callback="callback"
      />
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Offer from "@/components/Pages/Dashboard/Orders/Offers/Offer";
import HeaderForNewItem from "@/components/Pages/Dashboard/Orders/Offers/Templates/HeaderForNewItem.vue";
import AddRecordButton from "@/components/Pages/Dashboard/Orders/Offers/Templates/AddRecordButton.vue";

export default {
  name: "OffersList",
  components: {AddRecordButton, HeaderForNewItem, Offer},
  props: {
    callback: { //getOffers
      type: Function,
      default: () => {
      }
    }
  },

  data() {
    return {
      showOfferForm: false,
      newOfferLink: '',
      newOfferLinkError: '',
    }
  },

  computed: {
    ...mapGetters({
      offers: 'OffersModule/getOffers',
      order: 'OrderModule/getOrder',
    }),
  },

  methods: {
    ...mapActions({
      setOffers: 'OffersModule/setOffers',
      incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
      decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
    }),

    toggleOfferForm() {
      this.showOfferForm = !this.showOfferForm
    },

    addOffer() {
      if (this.newOfferLink.length) {
        this.incrementSpinnerCounter()
        this.toggleOfferForm()

        let data = {
          order_id: this.order.id,
          client_id: this.order.client_id,
          link: this.newOfferLink,
        }

        this.axios
            .post(`offers/create`, data)
            .then(response => {
              let message = response.data.message || "Success";
              this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
            })
            .then(() => {
              this.callback()
            })
            .finally(() => {
              this.newOfferLink = ''
              this.decrementSpinnerCounter()
            })
            .catch(error => {
              let message = error.message || "Щось пішло не так :/";
              this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
            })
      } else {
        this.newOfferLinkError = 'Посилання введено некоректно'
      }
    },
  }
}
</script>

<style scoped>

</style>