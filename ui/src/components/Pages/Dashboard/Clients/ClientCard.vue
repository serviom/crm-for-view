<template>
  <v-card
      elevation="0"
      rounded="0"
      class="overflow-y-auto"
  >
    <div class="d-flex blocked" v-if="load"></div>

    <v-sheet>
      <v-toolbar dark
                 color="primary"
                 elevation="0"
                 class="pl-4"
      >
        <v-toolbar-title>{{ cardTitle }}
          <span v-if="client.status.is_archive">(архівний)</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-tooltip
              v-if="$auth.check(['SuperAdmin', 'clients.update'] ,'permissions')"
              bottom color="primary"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                  dark text
                  v-bind="attrs"
                  v-on="on"
                  @click="openCrmDialog(client.status.is_archive ? 'unarchive' : 'archive')"
              >
                <v-icon>mdi-archive</v-icon>
              </v-btn>
            </template>
            <span v-if="client.status.is_archive">Розархівувати</span>
            <span v-if="!client.status.is_archive">Архівувати</span>
          </v-tooltip>
          <v-tooltip
              v-if="!client.status.is_archive && $auth.check(['SuperAdmin', 'clients.delete'] ,'permissions')"
              bottom color="primary"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                  dark text
                  v-bind="attrs"
                  v-on="on"
                  @click="openCrmDialog(client.user_id ? 'cancel' : 'join')"
              >
                <v-icon v-if="client.user_id">mdi-briefcase-remove</v-icon>
                <v-icon v-else>mdi-briefcase-account</v-icon>
              </v-btn>
            </template>
            <span>{{ client.user_id ? 'Завершити співпрацю' : 'Почати працювати з клієнтом' }}</span>
          </v-tooltip>
          <v-tooltip
              v-if="$auth.check(['SuperAdmin', 'clients.update'] ,'permissions')"
              bottom color="primary"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                  dark text
                  v-bind="attrs"
                  v-on="on"
                  :to="{ name: 'clients.update', params: { id: client.id } }"
              >
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
            </template>
            <span>Редагувати дані клієнта</span>
          </v-tooltip>
          <v-btn
              dark text
              @click="hide"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
    </v-sheet>

    <v-progress-linear
        v-if="load"
        color="primary accent-4"
        indeterminate
        rounded
        height="2"
        style="top:1px"
    ></v-progress-linear>

    <div class="px-4">
      <v-card-text>
        <div class="d-block d-md-flex justify-content-between align-items-start">
          <div>
            <div v-if="client.income_source_id && getIncomeSources.length" class="mb-3">
                            <span class="mr-2 font-weight-bold">Джерело надходження:</span
                            >{{ getIncomeSources.find(item => item.id === client.income_source_id)['title'] }}
              <div
                  v-if="getIncomeSources.find(item => item.id === client.income_source_id)['with_comment'] && client.income_source"
              ><span
                  class="mr-2 font-weight-bold">Коментар:</span>{{ client.income_source }}
              </div>
            </div>
            <div class="mb-6">{{ client.description }}</div>
          </div>
        </div>

        <div class="d-flex justify-content-between">
          <client-phones :phones="(client.phoneNumbers ? client.phoneNumbers : client.phone_numbers)" class="mb-3"/>
        </div>

        <v-divider class="mb-0"></v-divider>

        <div class="w-100 position-relative">
          <v-row>
            <v-col cols="12" lg="6">
              <div class="d-flex justify-content-between align-items-center py-3 mb-4">
                <v-card-title class="p-0">Угоди клієнта</v-card-title>

                <v-tooltip left color="primary">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        color="primary"
                        class="white--text"
                        fab small
                        @click="newOrder"
                        v-bind="attrs"
                        v-on="on"
                    >
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                  </template>
                  <span>Додати угоду</span>
                </v-tooltip>

                <v-dialog
                    v-model="showOrderForm"
                    max-width="600px"
                >
                  <order-form
                      :item="temp"
                      :buttons="true"
                      :toggleDialog="toggleOrderForm"
                      @saveOrder="saveOrder"
                  />
                </v-dialog>
              </div>

              <orders-list
                  v-show="showOrders"
              />
            </v-col>
            <v-col cols="12" lg="6">
              <div class="d-flex justify-content-between align-items-center py-3 mb-4">
                <v-card-title class="p-0">Коментарі</v-card-title>
              </div>

              <comment-form
                  style="margin-top: -30px"
                  entity="clients"
                  :id="client.id"
                  :callback="incrementComments"
              />

              <comments-list
                  entity="clients"
                  :data="orders"
                  :id="client.id"
                  :reload="reloadComments"
              />
            </v-col>
          </v-row>

        </div>

      </v-card-text>
    </div>

    <crm-dialog
        :isShowDialog="showCrmDialog"
        :isShowSpinner="showCrmSpinner"
        :disableActionBtnText="isDisableActionBtnText"
        :isAction="true"
        :isCancelBtn="true"
        maxWidth="600"
        color="warning"
        actionBtnText="Так"
        defaultBtnText=""
        cancelBtnText="Ні"
        @successEvent="crmDialogCallback"
        @closeDialog="showCrmDialog = false"
    >
      <template v-slot:info-title>{{ titleCrmDialog }}</template>

      <template v-slot:info-text>
        {{ textCrmDialog }}
        <b v-if="crmDialogItem && crmDialogItemProperty"
        >{{ crmDialogItem[crmDialogItemProperty] }}</b>?

        <div class="mt-4">
          <v-select
              v-if="showAddSelectedOptions"
              v-model="selectedItem"
              :items="formattedItems"
              :label="labelReasonSelect"
              chips
              small-chips
              clearable
              filterable
          ></v-select>

          <v-text-field
              v-if="showAddSelectedOptions && selectedItem === idSelectCustomItem"
              v-model="customInput"
              label="Введіть свій варіант"
              clearable
          ></v-text-field>
        </div>
      </template>
    </crm-dialog>
  </v-card>
</template>

<script>
import ClientPhones from "@/components/Pages/Dashboard/Clients/Card/ClientPhones";
import OrderForm from "@/components/Pages/Dashboard/Orders/Form";
import {mapActions, mapGetters} from "vuex";
import OrderModel from "@/models/OrderModel";
import CrmDialog from "@/components/Common/Template/CrmDialog";
import {cloneDeep as _cloneDeep} from 'lodash';
import OrdersList from "@/components/Pages/Dashboard/Orders/List";
import CommentForm from "@/components/Pages/Dashboard/Comments/CommentForm";
import CommentsList from "@/components/Pages/Dashboard/Comments/CommentsList";

export default {
  name: 'ClientCard',
  components: {OrderForm, ClientPhones, CrmDialog, OrdersList, CommentForm, CommentsList},
  props: {
    client: {
      type: Object,
      required: true
    },
    reload: {
      type: Boolean,
      required: true
    },
    hide: {
      type: Function
    },
    getList: {
      type: Function,
      default: () => {
      }
    },
  },

  mounted() {
    this.request('orders-list')
    this.getHandbooks()
  },

  computed: {
    ...mapGetters({
      orders: 'OrderModule/getOrders',
      getIncomeSources: 'IncomeSourcesModule/getList',
    }),
    formattedItems() {
      const items = this.getItemsForSelect();
      return Object.keys(items).map(key => ({
        value: Number(key),
        text: items[key],
      }))
    },
    showAddSelectedOptions() {
      return ['archive', 'cancel'].includes(this.crmDialogKey);
    },
    isDisableActionBtnText() {
      return this.showAddSelectedOptions && !this.isSelectItemNotEmpty;
    },
    isSelectItemNotEmpty() {
      return  (this.selectedItem === this.idSelectCustomItem && this.customInput) ||
          (this.selectedItem && this.selectedItem !== this.idSelectCustomItem)
    }
  },

  watch: {
    reload() {
      if (this.reload) {
        this.request('orders-list')
        this.cardTitle = this.client.fio
      }
    }
  },

  data() {
    return {
      showCrmDialog: false,
      showCrmSpinner: false,
      titleCrmDialog: 'Увага!',
      textCrmDialog: 'Ви дійсно хочете видалити клієнта',
      reloadComments: 0,

      crmDialogKey: 'delete',
      crmDialogItem: null,
      crmDialogItemProperty: 'fio',

      cardTitle: this.client.fio,
      load: false,
      showOrders: false,
      showOrderForm: false,
      temp: _cloneDeep(OrderModel),
      customInput: '',
      showCustomInput: false,
      selectedItem: 0,
      idSelectCustomItem: 999,
      labelReasonSelect: 'Вкажіть будь ласка причину'
    };
  },

  methods: {
    ...mapActions({
      setIncomeSourcesList: 'IncomeSourcesModule/setList',
      setOrders: 'OrderModule/setOrders',
      incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
      decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
    }),
    getSelectText() {
       return this.selectedItem !== this.idSelectCustomItem ? (this.getItemsForSelect()[this.selectedItem] ?? '') : this.customInput;
    },
    itemsForCancelMode() {
      return {
        1: 'сам не знає що хоче',
        2: 'шукає щось нереальне',
        [this.idSelectCustomItem]: 'свій варіант'
      }
    },
    itemsForArchiveMode() {
      return {
        1: 'не актуально',
        2: 'відложили',
        3: 'купили з нами',
        [this.idSelectCustomItem]: 'свій варіант'
      }
    },
    getItemsForSelect() {
      switch(this.crmDialogKey) {
        case 'archive':
            return this.itemsForArchiveMode();
        case 'cancel':
            return this.itemsForCancelMode();
        default:
            return {};
      }
    },
    async getHandbooks() {
      await this.axios
          .get(`handbook/income_sources`, {})
          .then(response => {
            this.setIncomeSourcesList(response.data.data)
          })
          .catch(error => {
          })
          .then(() => {
          })
    },

    toggleOrderForm() {
      this.showOrderForm = !this.showOrderForm
    },

    newOrder() {
      this.resetTempData()
      this.toggleOrderForm()
    },

    saveOrder() {
      this.showOrderForm = false

      let data = {
        id: this.temp.id,
        client_id: this.client.id,
        key: 'save',
        fields: {
          adv_type: this.temp.adv_type,
          category: this.temp.category,
          type: this.temp.type,
          repair: this.temp.repair,
          price: this.temp.price,
          walls: this.temp.walls,
          floor: this.temp.floor,
          districts: this.temp.districts,
          rooms: this.temp.rooms,
          comment: this.temp.comment,
          stage_id: this.temp.stage_id,
          created_at: this.temp.created_at
        }
      }
      if (!data.id) data.fields.client_id = this.client.id

      this.request('save', data)
    },

    openCrmDialog(key) {
      switch (key) {
        case 'delete':
          this.titleCrmDialog = 'Увага!'
          this.textCrmDialog = 'Ви дійсно хочете видалити клієнта'
          break
        case 'join':
          this.titleCrmDialog = 'Ви впевнені?'
          this.textCrmDialog = 'Що хочете почати співпрацювати з клієнтом'
          break
        case 'cancel':
          this.selectedItem = 0;
          this.customInput = '';
          this.titleCrmDialog = 'Ви впевнені?'
          this.textCrmDialog = 'Ви впевнені, що хочете завершити співпрацю з клієнтом'
          break
        case 'archive':
          this.selectedItem = 0;
          this.customInput = '';
          this.titleCrmDialog = 'Ви впевнені?'
          this.textCrmDialog = 'Ви впевнені, що хочете архівувати клієнта'
          break
        case 'unarchive':
          this.titleCrmDialog = 'Ви впевнені?'
          this.textCrmDialog = 'Ви впевнені, що хочете розархівувати клієнта'
          break
      }

      this.crmDialogItem = this.client
      this.crmDialogKey = key
      this.showCrmDialog = true
    },

    crmDialogCallback() {
      this.showCrmSpinner = true

      switch (this.crmDialogKey) {
        case 'delete':
          this.request('delete-client')
          break
        case 'join':
          this.request('join-client')
          break
        case 'cancel':
          this.request('cancel-client')
          break
        case 'archive':
          this.request('archive-client')
          break
        case 'unarchive':
          this.request('unarchive-client')
          break
      }
    },

    incrementComments() {
      this.reloadComments += 1
    },

    async request(act, data = {}) {
      this.load = true

      switch (act) {
        case 'orders-list': {
          this.setOrders([])
          this.axios
              .post(`orders`, {
                'client_id': this.client.id,
                'sort': 'closed_at',
                'with_client_data': true
              })
              .then(response => {
                this.setOrders(response.data.list)
              })
              .catch(error => {
                let message = error || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.load = false
                this.showOrders = true
                this.resetTempData()
              })
          break
        }

        case 'save': {
          this.axios
              .post(`order/save`, data)
              .then(response => {
                let message = response.data.message || "Success";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
              })
              .catch(error => {
                let message = error.message || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.request('orders-list')
              })
              .then(() => {
                this.incrementComments()
              })
          break
        }

        case 'getOrder': {
          this.incrementSpinnerCounter()

          this.axios
              .get(`order/${data.id}`, {})
              .then(response => {
                if (response.data.success) {
                  this.temp.districts = response.data.order.districts
                  this.temp.rooms = response.data.order.rooms
                }
              })
              .catch(error => {
                let message = error.message || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.load = false
              }).finally(() => this.decrementSpinnerCounter())
          break
        }

        case 'delete-client': {
          this.incrementSpinnerCounter()

          this.axios
              .delete(`clients/${this.crmDialogItem.id}`)
              .then(response => {
                let message = response.data.message || "Success";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
              })
              .catch(error => {
                let message = error.message || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.hide()
                this.getList()
              })
              .then(() => {
                this.load = false
                this.showCrmDialog = false
                this.showCrmSpinner = false
              }).finally(() => this.decrementSpinnerCounter())
          break
        }

        case 'join-client': {
          this.incrementSpinnerCounter()

          this.axios
              .put(`clients/${this.crmDialogItem.id}`, {
                user_id: this.$auth.user().id,
                fio: this.crmDialogItem.fio,
                social: this.crmDialogItem.social,
                phoneNumbers: this.crmDialogItem.phoneNumbers,
              })
              .then(response => {
                let message = response.data.message || "Success";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
              })
              .catch(error => {
                let message = error.message || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.$emit('joinClient')
                this.incrementComments()
              })
              .then(() => {
                this.getList()
              })
              .then(() => {
                this.load = false
                this.showCrmDialog = false
                this.showCrmSpinner = false
              }).finally(() => this.decrementSpinnerCounter())
          break
        }

        case 'archive-client': {
          this.incrementSpinnerCounter()

          this.axios
              .put(`clients/${this.crmDialogItem.id}`, {
                user_id: null,
                fio: this.crmDialogItem.fio,
                social: this.crmDialogItem.social,
                phoneNumbers: this.crmDialogItem.phoneNumbers,
                archive: 1,
                selectText: this.getSelectText()
              })
              .then(response => {
                let message = response.data.message || "Success";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
              })
              .catch(error => {
                let message = error.message || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.hide()
                this.getList()
              })
              .finally(() => {
                this.load = false
                this.showCrmDialog = false
                this.showCrmSpinner = false
                this.decrementSpinnerCounter()
              })
          break
        }

        case 'unarchive-client': {
          this.incrementSpinnerCounter()

          this.axios
              .put(`clients/${this.crmDialogItem.id}`, {
                user_id: null,
                fio: this.crmDialogItem.fio,
                social: this.crmDialogItem.social,
                phoneNumbers: this.crmDialogItem.phoneNumbers,
                archive: 0
              })
              .then(response => {
                let message = response.data.message || "Success";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
              })
              .catch(error => {
                let message = error.message || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.hide()
                this.getList()
              })
              .finally(() => {
                this.load = false
                this.showCrmDialog = false
                this.showCrmSpinner = false
                this.decrementSpinnerCounter()
              })
          break
        }

        case 'cancel-client': {
          this.incrementSpinnerCounter()

          this.axios
              .put(`clients/${this.crmDialogItem.id}`, {
                user_id: null,
                fio: this.crmDialogItem.fio,
                social: this.crmDialogItem.social,
                phoneNumbers: this.crmDialogItem.phoneNumbers,
                selectText: this.getSelectText()
              })
              .then(response => {
                let message = response.data.message || "Success";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
              })
              .catch(error => {
                let message = error.message || "Щось пішло не так :/";
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
              })
              .then(() => {
                this.hide()
                this.incrementComments()
              })
              .then(() => {
                this.getList()
              })
              .then(() => {
                this.load = false
                this.showCrmDialog = false
                this.showCrmSpinner = false
                this.decrementSpinnerCounter()
              })
          break
        }
      }
    },

    resetTempData() {
      this.temp.id = null
      this.temp.adv_type = 'Купівля'
      this.temp.category = null
      this.temp.type = null
      this.temp.repair = null
      this.temp.price = null
      this.temp.rooms = null
      this.temp.walls = null
      this.temp.floor = null
      this.temp.district = null
      this.temp.comment = null
    },
  }
}
</script>

<style scoped>
.blocked {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 10;
  background: rgba(255, 255, 255, 0.4);
}
</style>