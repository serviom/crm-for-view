<template>
    <v-card
        elevation="0"
        rounded="0"
        class="overflow-y-auto"
    >
        <div class="d-flex blocked" v-if="load"></div>

        <v-sheet>
            <v-toolbar
                dark
                color="primary"
                elevation="0"
                class="pl-4"
            >
                <v-toolbar-title
                    :class="{ 'closed-order': order.closed_at }"
                >{{ order.category + (order.rooms && order.rooms.length ? ', ' + order.rooms + 'к' : '') + (order.adv_type ? ', ' + order.adv_type : '') }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-tooltip
                        v-if="$auth.check(['SuperAdmin', 'clients.update'] ,'permissions')"
                        bottom color="primary"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                @click="toggleOrderForm"
                                dark text
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </template>
                        <span>Редагувати угоду</span>
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

        <div class="px-4">
            <div class="mt-6 px-md-4" :class="{ 'closed-order': order.closed_at }">
                <v-toolbar-title class="mb-3 fs-15" v-if="this.order.client && this.order.client.fio">{{ this.order.client.fio }}</v-toolbar-title>
                <div
                    class="d-flex"
                    v-if="this.order.client && (!!this.order.client.phone_numbers.length || this.order.client.social)"
                >
                    <div class="justify-content-between d-inline-flex" v-if="!!this.order.client.phone_numbers.length">
                        <client-phones :phones="this.order.client.phone_numbers" />
                    </div>
                    <div class="d-inline-flex justify-content-between" v-if="this.order.client.social">
                        <v-chip
                            link
                            color="success"
                            :href="this.order.client.social"
                            target="_blank"
                        >{{ this.order.client.social }}
                        </v-chip>
                    </div>
                </div>

                <v-divider class="mb-0"></v-divider>
            </div>

            <v-card-text>
                <v-row>
                    <v-col cols="12" lg="6" :class="{ 'closed-order': order.closed_at }">
                        <v-row align="center" class="mt-2 ml-md-0 fs-15">
                            <v-col class="pl-0 border-bottom border-bottom-dashed">
                                <v-row align="center">
                                    <v-col>
                                        <b>Тип угоди</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.adv_type }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="order.stage_id">
                                <v-row align="center">
                                    <v-col>
                                        <b>Етап угоди</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.stage_id ? dynprops.stages.filter(item => item.id === order.stage_id)[0]['title'] : '' }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed">
                                <v-row align="center">
                                    <v-col>
                                        <b>Тип нерухомості</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.category }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed"
                                   v-if="order.adv_type !== 'Продаж' && order.districts  && order.districts.length"
                            >
                                <v-row align="center">
                                    <v-col>
                                        <b>Район</b>:
                                    </v-col>
                                    <v-col>
                                        <span
                                            class="d-inline"
                                            v-for="(i, k) in districts.filter(item => order.districts.includes(item.id))"
                                            :key="k"
                                        >{{ (k>0 ? ', ' : '') + i.title }}</span>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="order.adv_type === 'Продаж' && order.street">
                                <v-row align="center">
                                    <v-col>
                                        <b>Вулиця</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.street }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="order.adv_type === 'Продаж' && order.house_number">
                                <v-row align="center">
                                    <v-col>
                                        <b>№ будинку</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.house_number }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="order.adv_type === 'Продаж' && order.apartment_number">
                                <v-row align="center">
                                    <v-col>
                                        <b>№ квартири</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.apartment_number }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-show="order.category !== 'Ділянка' && order.type">
                                <v-row align="center">
                                    <v-col>
                                        <b>Вид об'єкта</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.type }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-show="order.category !== 'Ділянка' && order.repair">
                                <v-row align="center">
                                    <v-col>
                                        <b>Ремонт</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.repair }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="order.price">
                                <v-row align="center">
                                    <v-col>
                                        <b>{{ order.adv_type==='Продаж' ? 'Ціна' : 'Ціна до' }}</b>:
                                    </v-col>
                                    <v-col>
                                        {{ priceFormat(order.price) }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="order.category !== 'Ділянка' && order.walls">
                                <v-row align="center">
                                    <v-col>
                                        <b>Матеріал стін</b>:
                                    </v-col>
                                    <v-col>
                                        {{ dynprops.walls.find(item => item.id === order.walls)['title'] }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="(order.category === 'Квартира' || order.category === 'Кімната') && order.floors && order.floors.length">
                                <v-row align="center">
                                    <v-col>
                                        <b>Поверх</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.floors.join(', ') }}
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12 pl-0 border-bottom border-bottom-dashed" v-if="(order.category !== 'Ділянка' && order.category !== 'Кімната') && order.rooms && order.rooms.length">
                                <v-row align="center">
                                    <v-col>
                                        <b>Кількість кімнат</b>:
                                    </v-col>
                                    <v-col>
                                        {{ order.rooms.join(', ') }}
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>

                        <v-row align="center" class="mt-8 ml-md-0 fs-15">
                            <offers-list
                                :callback="()=>{
                                    getOffers();
                                    incrementComments();
                                  }"
                            />
                        </v-row>

                        <v-row align="center" class="mt-8 ml-md-0 fs-15">
                          <order-audio-list
                              :callback="()=>{
                                  getOrderAudious();
                                  incrementComments();
                              }"
                          />
                        </v-row>
                    </v-col>

                    <v-col cols="12" lg="6" class="px-0 px-md-3">
                        <div class="v-card__text pt-0 pr-0 pl-0 pl-md-3" v-if="order.id">
                            <comment-form
                                entity="order"
                                :id="order.id"
                                :clientID="order.client.id"
                                :saveOrder="saveOrder"
                                :callback="incrementComments"
                            />
                            <comments-list
                                entity="order"
                                :id="order.id"
                                :reload="reloadComments"
                            />
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-dialog
                v-model="showOrderForm"
                max-width="600px"
            >
                <order-form
                    :item="temp"
                    :buttons="true"
                    :callback="{incrementComments, cancelOrderForm}"
                    :toggleDialog="toggleOrderForm"
                    @saveOrder="saveOrder"
                />
            </v-dialog>
        </div>

        <crm-dialog
            :isShowDialog="isShowDeleteDialog"
            :isShowSpinner="isShowDeletionSpinner"
            :isAction="true"
            maxWidth="600"
            color="warning"
            actionBtnText="Видалити"
            defaultBtnText=""
            cancelBtnText=""

            @successEvent="deleteCallback"
            @closeDialog="isShowDeleteDialog = false"
        >
            <template v-slot:info-title>
                Увага!
            </template>

            <template v-slot:info-text>
                Ви дійсно хочете видалити угоду <b v-if="itemToDelete">{{ itemToDelete.category + (itemToDelete.rooms ? ', ' + itemToDelete.rooms : '') }}</b>?
            </template>

        </crm-dialog>
    </v-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {cloneDeep as _cloneDeep} from 'lodash';
import priceFormatter from "@/mixin/priceFormatter";
import CrmDialog from "@/components/Common/Template/CrmDialog";
import OrderForm from "@/components/Pages/Dashboard/Orders/Form";
import CommentsList from "@/components/Pages/Dashboard/Comments/CommentsList";
import CommentForm from "@/components/Pages/Dashboard/Comments/CommentForm";
import OffersList from "@/components/Pages/Dashboard/Orders/Offers/List";
import OrderAudioList from "@/components/Pages/Dashboard/Orders/Offers/OrderAudioList";
import ClientPhones from "@/components/Pages/Dashboard/Clients/Card/ClientPhones";
import OrderModel from "@/models/OrderModel";
import dateFormatter from "@/mixin/dateFormatter";
import reminder from "@/mixin/reminder";

export default {
    name: 'OrderCard',
    components: {CrmDialog,OrderForm,CommentsList,CommentForm,ClientPhones,OffersList, OrderAudioList},
    mixins: [priceFormatter,dateFormatter,reminder],
    data() {
        return {
            isShowDeleteDialog: false,
            isShowDeletionSpinner: false,
            itemToDelete: null,
            itemToDeleteProperty: 'category',
            load: false,
            showOrderForm: false,
            showCancelOrderForm: false,
            temp: _cloneDeep(OrderModel),
            reloadComments: 0,
        }
    },
    mounted() {
        if(!this.dynprops.stages) this.getDynprops()
        if(!this.districts.length) this.getDistricts()
        this.request('get-order', {id:this.order.id})
        this.getOffers()
        this.getOrderAudious()
    },
    watch: {
        order: {
            handler(newValue, oldValue) {
                if (oldValue.id !== newValue.id) {
                    this.setTempData(OrderModel)
                    this.setTempData(newValue)

                    this.request('get-order', {id: newValue.id})

                    this.getOffers()
                    this.getOrderAudious();
                }
            },
            deep: true,
        },
    },
    computed: {
        ...mapGetters({
            districts: 'DistrictsModule/getDistricts',
            dynprops: 'DynpropsModule/getDynprops',
            order: 'OrderModule/getOrder',
            callback: 'OrderCardModule/getCallback',
        }),
    },
    methods: {
        ...mapActions({
            setDistricts: 'DistrictsModule/setDistricts',
            setDynprops: 'DynpropsModule/setDynprops',
            setOffers: 'OffersModule/setOffers',
            setAudious: 'OrderAudiousModule/setAudious',
            setOrder: 'OrderModule/setOrder',
            setEvents: 'EventsModule/setEvents',
            setCard: 'CardModule/setShow',
            setOrderCard: 'OrderCardModule/setShow',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

      async getOffers() {
        this.setOffers([])
        this.load = true

        await this.axios
            .get(`offers/${this.order.id}`, {})
            .then(response => {
              this.setOffers(response.data.data)
            })
            .finally(() => {
              this.load = false
            })
            .catch(error => {
              let message = error.message || "Щось пішло не так :/";
              this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
            })
      },

      async getOrderAudious() {
        this.setAudious([])
        this.load = true

        await this.axios
            .get(`order-audious/${this.order.id}`, {})
            .then(response => {
              this.setAudious(response.data.data)
            })
            .finally(() => {
              this.load = false
            })
            .catch(error => {
              let message = error.message || "Щось пішло не так :/";
              this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
            })
      },

        //

        toggleOrderForm() {
            this.showOrderForm = ! this.showOrderForm
        },

        saveOrder(order) {
            this.showOrderForm = false

            let data = {
                id: order.id,
                client_id: order.client_id,
                key: 'save',
                fields: {
                    adv_type: order.adv_type,
                    category: order.category,
                    type: order.type,
                    repair: order.repair,
                    price: order.price,
                    walls: order.walls,
                    districts: order.districts,
                    rooms: order.rooms,
                    floors: order.floors,
                    stage_id: order.stage_id,
                    created_at: order.created_at,
                    closed_at: null
                }
            }
            if( ! data.id) data.fields.client_id = order.client_id
            if(this.dynprops.stages.find(stage => stage.id === order.stage_id).is_last) {
                data.fields.closed_at = this.dateFormat()
            }
            this.request('save', data)
        },

        cancelOrderForm() {
            this.showOrderForm = false
            this.showCancelOrderForm = true
        },

        cancelOrder() {
            let data = {
                id: this.order.id,
                key: 'cancel',
            }

            this.request('cancel', data)
        },

        showDeleteDialog(item) {
            this.itemToDelete = item;
            this.isShowDeleteDialog = true;
        },

        deleteCallback() {
            this.isShowDeletionSpinner = true

            this.request('remove', {id:this.itemToDelete.id})
        },

        getEvents() {
            this.eventsLoading = true

            if(this.$auth.user().id) {
                this.axios
                    .get(`reminder`,)
                    .then(response => {
                        this.setEvents(response.data)
                    })
                    .catch(error => {})
                    .then(() => {
                        this.eventsLoading = false
                    })
            }
        },

        async request(act, data={}) {
            this.load = true
            this.incrementSpinnerCounter()

            switch (act) {
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
                            this.request('get-order', {id:data.id})
                        })
                        .then(() => {
                            this.incrementComments()
                            this.callback()
                        })
                        .finally(() => {
                            this.load = false
                            this.decrementSpinnerCounter()
                        })
                    break
                }

                case 'remove': {
                    this.axios
                        .delete(`order/${data.id}`)
                        .then(response => {
                            let message = response.data.message || "Success";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
                        })
                        .catch(error => {
                            let message = error.message || "Щось пішло не так :/";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                        })
                        .then(() => {
                            this.callback()
                        })
                        .then(() => {
                            this.hide()
                            this.isShowDeleteDialog = false
                            this.isShowDeletionSpinner = false
                        })
                        .then(() => {
                            this.load = false
                            this.decrementSpinnerCounter()
                        })
                    break
                }

                case 'cancel': {
                    this.axios
                        .post(`order/cancel`, data)
                        .then(response => {
                            let message = response.data.message || "Success";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
                        })
                        .catch(error => {
                            let message = error.message || "Щось пішло не так :/";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                        })
                        .then(() => {
                            this.request('get-order', {id:this.order.id})
                        })
                        .then(() => {
                            this.callback()
                        })
                        .then(() => {
                            this.getEvents()
                        })
                        .then(() => {
                            this.incrementComments()
                            this.showCancelOrderForm = false
                            this.load = false
                            this.decrementSpinnerCounter()
                        })
                    break
                }

                case 'get-order': {
                    this.axios
                        .get(`order/${data.id}`, {})
                        .then(response => {
                            this.setTempData(response.data.data)
                            this.setOrder(response.data.data)
                        })
                        .catch(error => {
                            let message = error.message || "Щось пішло не так :/";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                        })
                        .then(() => {
                            this.load = false
                            this.decrementSpinnerCounter()
                        })
                    break
                }
            }
        },

        setTempData(order) {
            for(const [key, value] of Object.entries(order)) {
                this.temp[key] = value
            }
        },

        async getDistricts() {
            let params = {
                city_id: 1,
                all: true
            }

            await this.axios
                .get(`handbook/districts`, {params})
                .then(response => {
                    this.setDistricts(response.data)
                })
                .catch(error => {})
                .then(() => {})
        },

        async getDynprops() {
            this.incrementSpinnerCounter()

            await this.axios
                .get(`dynprops`, {params:{withMyClients:true}})
                .then(response => {
                    this.setDynprops(response.data)
                })
                .catch(error => {})
                .then(() => {
                    if(!this.temp.stage_id) this.temp.stage_id = this.dynprops.stages[0].id
                })
                .finally(() => {
                    this.decrementSpinnerCounter()
                });
        },

        incrementComments(){
            this.reloadComments += 1
        },

        hide() {
			this.setCard(false)
            this.setOrderCard(false)
        }
    }
}
</script>

<style scoped>
.fs-15 {
    font-size: 15px;
}
.fs-18 {
    font-size: 18px;
}
.border-bottom-dashed {
    border-bottom-style: dashed !important;
}
.comments-block {
    background-color: rgba(0,0,0,0.03);
}
</style>