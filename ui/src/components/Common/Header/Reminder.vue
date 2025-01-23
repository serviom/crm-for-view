<template>
    <v-menu left
            v-model="menu"
            :close-on-content-click="false"
            offset-y
    >
        <template v-slot:activator="{ on, attrs }">
            <v-badge bordered left overlap
                     :icon="eventsLoading ? 'mdi-autorenew mdi-spin' : events.length.toString()"
                     :class="'remind-badge' + (eventsLoading ? ' fs-12' : '')"
                     color="error"
                     offset-x="22"
                     offset-y="25"
                     :value="events.length"
            >
                <v-btn icon fab
                       color="info"
                       v-bind="attrs"
                       v-on="on"
                >
                    <v-icon dense size="25">mdi-bell</v-icon>
                </v-btn>
            </v-badge>
        </template>

        <v-card class="remind-container">
            <div class="blocked" v-if="blocked"></div>
            <v-list class="remind-list py-0">
                <v-list-item
                    v-for="event in events"
                    :key="event.id"
                    :class="'remind-item-container py-3' + (openItem === event.id ? ' open' : '')"
                >
                    <div class="d-flex flex-column remind-item">
                        <div class="d-flex">
                            <v-list-item-content
                                class="remind-item-desc py-0"
                                @click="toggleItem(event.id)"
                            >
                                <v-list-item-title v-if="event.client">{{ event.client.fio }}</v-list-item-title>
                                <v-list-item-subtitle>{{ event.title }}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action class="my-0 align-self-start">
                                <v-tooltip
                                    v-if="event.type===2"
                                    left color="info"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <div
                                            v-on="on"
                                            v-bind="attrs"
                                        >

                                            <v-btn
                                                color="info"
                                                class="white--text"
                                                fab x-small outlined
                                                v-bind="attrs"
                                                v-on="on"
                                                @click="editOrder(event)"
                                            >
                                                <v-icon>mdi-transfer-right</v-icon>
                                            </v-btn>

                                        </div>
                                    </template>
                                    <span>Змінити етап</span>
                                </v-tooltip>
                                <template v-if="event.type===1">
                                  <v-btn
                                      color="info"
                                      class="white--text"
                                      @click="closeEvent(event.id)"
                                  >
                                      Взяти в роботу
                                  </v-btn>
                                </template>
                            </v-list-item-action>
                        </div>

                        <v-expand-transition v-if="event.client && event.client.phone_numbers.length">
                            <div v-show="(openItem === event.id)">
                                <v-divider></v-divider>
                                <client-phones
                                    :phones="event.client.phone_numbers"
                                    :xSmall="true"
                                />

                                <v-list-item-subtitle v-if="event.comment" v-text="event.comment" class="mt-2"></v-list-item-subtitle>
                            </div>
                        </v-expand-transition>

                    </div>
                </v-list-item>
            </v-list>
        </v-card>

        <v-dialog
            v-model="showOrderForm"
            max-width="600px"
        >
            <v-card class="no-border">
                <div class="d-flex align-items-center justify-content-between">
                    <v-card-title class="pt-4 px-5 px-md-8">{{ title }}</v-card-title>

                    <v-card-actions class="pt-3 pb-0 px-6 d-flex justify-content-between">
                        <v-btn
                            color="grey"
                            text icon
                            @click="toggleOrderForm"><v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-actions>
                </div>

                <div class="v-card__text px-4" v-if="temp.id && $auth.check(['SuperAdmin', 'clients.update'] ,'permissions')">
                    <v-col cols="12" class="comments-block">
                        <v-select
                            dense
                            required
                            :rules="[rules.required]"
                            v-model="temp.stage_id"
                            :items="dynprops.stages"
                            item-text="title"
                            item-value="id"
                            label="Етап угоди"
                            hide-details
                        ></v-select>
                    </v-col>

                    <v-col cols="12" class="comments-block px-3">
                        <comment-form
                            entity="order"
                            :id="temp.id"
                            :clientID="temp.client_id"
                            :stageChanged="stageChanged"
                            :oldStage="oldStage"
                            :newStage="newStage"
                            :dateTime="{date, time}"
                            :callback="stageChangedCallback"
                        />

                        <comments-list
                            entity="order"
                            class="mt-5"
                            :id="temp.id"
                            :reload="reloadComments"
                        />
                    </v-col>
                </div>
            </v-card>

        </v-dialog>

    </v-menu>
</template>

<script>
import {mapActions, mapGetters} from "vuex"
import ClientPhones from "@/components/Pages/Dashboard/Clients/Card/ClientPhones"
import CommentForm from "@/components/Pages/Dashboard/Comments/CommentForm"
import CommentsList from "@/components/Pages/Dashboard/Comments/CommentsList"
import OrderForm from "@/components/Pages/Dashboard/Orders/Form";
import OrderModel from "@/models/OrderModel";
import CrmDialog from "@/components/Common/Template/CrmDialog";
import {cloneDeep as _cloneDeep} from 'lodash';
import reminder from "@/mixin/reminder";
import dateFormatter from "@/mixin/dateFormatter";

export default {
    name: "Reminder",
    mixins: [reminder, dateFormatter],
    components: {
        ClientPhones,
        OrderForm,
        CommentForm,
        CommentsList,
        CrmDialog
    },
    data() {
        return {
            rules: {
                required: v => !!v || 'Це поле обов`язкове',
                maxLength: len => v => (v || '').length <= len || `Невірна довжина коментаря, має бути не більше ${len}`,
                minLength: len => v => (v || '').length >= len || `Невірна довжина коментаря, має бути не менше ${len}`,
                email: v => !!(v || '').match(/@/) || 'Please enter a valid email',
                password: v => !!(v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
                    'Password must contain an upper case letter, a numeric character, and a special character',
            },
            eventsLoading: false,
            blocked: false,
            menu: false,
            openItem: false,
            showOrderForm: false,
            title: 'Наступний етап',
            temp: _cloneDeep(OrderModel),
            eventID: null,

            stage: null,
            stageChanged: false,
            reloadComments: 0,
            oldStage: null,
            newStage: null,

            showExtendTimeDeleteDialog: false,
            showExtendTimeDeletionSpinner: false,
            date: null,
            time: null,
            calendar: false,
            timepicker: false
        };
    },
    watch: {
        temp: {
            handler(newValue, oldValue) {
                if (newValue.id) {
                    this.oldStage = this.dynprops.stages.find(item => item.id === this.stage)
                    this.newStage = {is_last: false}
                    this.stageChanged = (this.stage !== this.temp.stage_id)

                    if (this.stageChanged) {
                        this.newStage = this.dynprops.stages.find(item => item.id === this.temp.stage_id)
                    }

                    let {date, time} = this.stageChanged ? this.getTime(this.newStage) : this.getTime(this.oldStage)
                    this.date = date
                    this.time = time
                }
            },
            deep: true,
        },
    },
    created() {
        this.getEvents()
    },
    async mounted() {
        this.renewEvents()

        if(!this.dynprops.stages) await this.getDynprops()
        else if(!this.temp.stage_id) this.temp.stage_id = this.dynprops.stages[0].id
    },
    computed: {
        ...mapGetters({
            events: 'EventsModule/getEvents',
            dynprops: "DynpropsModule/getDynprops",
        }),
    },
    methods: {
        ...mapActions({
            setEvents: 'EventsModule/setEvents',
            setDynprops: 'DynpropsModule/setDynprops',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        async getEvents() {
            if(this.$auth && this.$auth.user().id) {
                this.eventsLoading = true

                await this.axios
                    .get(`reminder`,)
                    .then(response => {
                        this.setEvents(response.data)
                    })
                    .catch(error => {})
                    .then(() => {
                        this.eventsLoading = false
                        this.blocked = false
                    })
            }
        },

        renewEvents() {
            setInterval(this.getEvents, 1000*60)
        },

        toggleItem(id) {
            this.openItem = this.openItem === id ? false : id
        },

        toggleOrderForm() {
            this.showOrderForm = ! this.showOrderForm
        },

        editOrder(item) {
            if(item.order_id) {
                if(this.stage !== item.order.stage_id) this.stage = item.order.stage_id

                this.temp.id = item.order.id
                this.temp.client_id = item.order.client_id
                this.temp.stage_id = item.order.stage_id

                this.title = item.client.fio
                this.eventID = item.id

                this.toggleOrderForm()
            } else {
                let message = 'Угоду не вказано';
                this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
            }
        },

        saveOrder() {
            let data = {
                id: this.temp.id,
                key: 'save',
                fields: {
                    stage_id: this.temp.stage_id,
                    created_at: this.temp.created_at
                }
            }

            if(this.newStage.is_last) {
                data.fields.closed_at = this.dateFormat()
            }

            this.request('save', data)
        },

        closeEvent(id = this.eventID) {
            this.eventsLoading = true
            this.blocked = true
            this.axios
                .post('event/close', {id})
                .then(response => {
                    if(this.newStage.is_last){
                        let message = response.data.message || 'Success';
                        this.eventHub.$emit('doShowSnackbarEvent', true, message, (response.data.success ? 'success' : 'error'), 5000)
                    }
                })
                .catch(error => {
                    console.log(error)
                })
                .then(() => {
                    this.getEvents()
                })
        },

        getDynprops() {
            this.incrementSpinnerCounter()

            this.axios
                .get(`dynprops`, {})
                .then(response => {
                    this.setDynprops(response.data)
                })
                .catch(error => {})
                .then(() => {
                    if(!this.temp.stage_id && this.dynprops.stages) this.temp.stage_id = this.dynprops.stages[0].id
                })
                .finally(() => {
                    this.decrementSpinnerCounter()
                });
        },

        incrementComments(){
            this.reloadComments += 1
        },

        async request(act, data={}) {
            switch (act) {
                case 'save': {
                    this.incrementSpinnerCounter()

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
                        .finally(() => {
                            this.decrementSpinnerCounter()
                        })
                    break
                }
                case 'order': {
                    this.incrementSpinnerCounter()

                    this.axios
                        .get(`order/${data.id}`, {})
                        .then(response => {
                            this.editOrder(response.data.order)
                        })
                        .catch(error => {
                            let message = error.message || "Щось пішло не так :/";
                            this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                        })
                        .finally(() => {
                            this.decrementSpinnerCounter()
                        })
                    break
                }
            }
        },

        extendTimeCallback() {
            this.incrementSpinnerCounter()

            let data = {
                id: this.eventID,
                remind_at: this.date + ' ' + this.time
            }

            this.axios
                .post(`event/restore`, data)
                .then(response => {
                    let message = response.data.message || "Success";
                    this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000);
                })
                .catch(error => {
                    let message = error.message || "Щось пішло не так :/";
                    this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                })
                .then(() => {
                    this.showExtendTimeDeleteDialog = false
                })
                .then(() => {
                    this.getEvents()
                })
                .finally(() => {
                    this.decrementSpinnerCounter()
                })
        },

        async stageChangedCallback() {
            if(this.stageChanged) {
                await this.closeEvent()
                await this.saveOrder()
            } else {
                await this.extendTimeCallback()
            }

            this.incrementComments()
            this.showOrderForm = false
            await this.getEvents()
        }

    }
}
</script>

<style scoped>
.remind-list {
    max-height: 350px;
    overflow: auto;
}
.remind-item-container {
    max-width: 700px;
    align-items: flex-start;
    min-height: auto;
}
.remind-item-container.open {
    background-color: rgba(33,150,243,0.07);
}
.remind-item {
    max-width: 100%;
    width: 100%;
}
.remind-item-container:not(:last-child) {
    border-bottom: 1px solid rgba(0,0,0,.12);
}
.remind-item-container:hover {
    background-color: rgba(33,150,243,0.1);
}
.remind-item-desc {
    cursor: pointer;
}
.remind-date {
    font-size: 9px;
}
.remind-item-container.open .v-list-item__subtitle {
    white-space: inherit;
}
@media (min-width: 767px) {
    .remind-list {
        max-height: 450px;
    }
}
</style>
<style>
.remind-badge .v-badge__badge {
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 14px;
    width: 14px;
    height: 14px;
    padding: 0;
}
.remind-badge .v-badge .v-badge__badge:after {
    width: 14px;
    height: 14px;
}
.remind-badge.v-badge--bordered .v-badge__badge:after {
    border-width: 1px;
}
.remind-badge .v-badge__badge .v-icon {
    font-size: 9px;
}
.remind-badge.fs-12 .v-badge__badge .v-icon {
    font-size: 12px;
}
.remind-container {
    position: relative;
}
.blocked {
    background: rgba(0,0,0,0.1);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 50;
}
@media (min-width: 767px) {
    .remind-container {
        min-width: 400px;
    }
}
</style>