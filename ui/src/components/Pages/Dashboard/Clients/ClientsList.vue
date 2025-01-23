<template>
    <crm-default-listing-page
        newItemBtnTitle="Новий клієнт"
        :isEnableNewItemBtn="$auth.check(['SuperAdmin', 'clients.create'] ,'permissions')"
        :newItemBtnLink="{name:'clients.create'}"
        :isShowDeleteDialog="isShowDeleteDialog"
        :isShowDeletionSpinner="isShowDeletionSpinner"
        :deleteItemCallback="()=>{}"
        @closeDialog="isShowDeleteDialog = false"
        :deleteItemTitle="deleteItemTitle"
        :itemToDelete="itemToDelete"
        :itemToDeleteProperty="itemToDeleteProperty"

        :isAdditionalBtn="true"
        :additionalIslBtn="true"
        :additionalBtnLink="{name:'help'}"
    >
        <template v-slot:filters>
            <filter-form
                :apply="applyFilters"
                :reset="resetFilters"
            />
        </template>

        <template v-slot:table>
            <crm-data-table-pagination
                :headers="headers"
                :sort="'last_updated_date'"
                :mustSort="true"
                :items="getClientsList"
                :items-per-page="10"
                :options.sync="options"
                :server-items-length="totalClients"
                class="set-tbody-d-table-row"
                :footer-props="{
                    'items-per-page-options': itemsPerPageOptions,
                    'items-per-page-text': itemsPerPageText,
                    'items-per-page-all-text': itemsPerPageAllText
                }"
            >
                <template v-slot:no-data>
                    <v-progress-circular
                        v-if="isShowTableSpinner"
                        indeterminate
                        color="primary"
                    ></v-progress-circular>
                    <span v-else>Немає клієнтів</span>
                </template>

                <template v-slot:no-results>
                    <span>Немає результатів пошуку</span>
                </template>

                <template
                    v-slot:item="{ item, index }"
                >
                    <tr :class="{ 'closed-order': item.status.is_archive }" class="cursor-pointer">
                        <td
                            @click="showOrderCard(item)"
                            class="pl-0"
							:class="{ 'closed-order': (item.order.closed_at) }"
                        >
                            <v-btn text small
                                   class="justify-start text-capitalize"
                                   color="blue"

                            >
                                <div class="d-flex">
                                    <v-icon v-if="item.order.category"
                                            size="25">{{ catIcon(item.order.category) }}
                                    </v-icon>
                                    <div class="ml-3 d-flex align-items-center">
                                        <span v-if="item.order.category">
                                            {{ item.order.category }}
                                        </span>
                                        <span v-else>-</span>
                                    </div>
                                </div>
                            </v-btn>
                        </td>
                        <td
                            @click="showOrderCard(item)"
                        >
                            <span v-if="item.order.adv_type">
                                {{ item.order.adv_type }}
                            </span>
                            <span v-else>-</span>
                        </td>
                        <td class="pl-1"
                            :data-item-id="item.id"
                            @click="handleShowOrderCard"
                        >
                            <div class="d-flex align-items-center" :data-item-id="item.id">
                                <v-tooltip
                                    v-if="item.is_agency"
                                    right color="info"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon fab small
                                               v-bind="attrs"
                                               v-on="on"
                                               color="info"
                                               class="open-client-card"
                                               @click="clientCard(item)"
                                        ><v-icon class="open-client-card" dense>mdi-face-agent</v-icon></v-btn>
                                    </template>
                                    <span>Агенство<span
                                        v-if="item.agency"
                                        > "{{ item.agency }}"</span>
                                    </span>
                                </v-tooltip>
                                <v-btn text small
                                       class="justify-start text-capitalize open-client-card"
                                       color="blue"
                                       @click="clientCard(item)"
                                >{{ item.fio }}</v-btn>
                            </div>
                        </td>
                        <td
                            @click="showOrderCard(item)"
                        >
                            <span v-if="item.order.stage_id && dynprops.stages">
                                {{ getStageTitle(item.order.stage_id) }}
                            </span>
                            <span v-else>-</span>
                        </td>
                        <td
                            @click="showOrderCard(item)"
                        >
                            {{ item.create_date }}
                        </td>

                        <td
                            @click="showOrderCard(item)"
                        >
                          {{ dateFormatWithTimezone(item.order.last_comment_date && item.order.last_comment_date > item.updated_at ? item.order.last_comment_date : item.updated_at) }}
                        </td>

                        <td
                            v-if="$auth.check(['SuperAdmin', 'users.update'] ,'permissions')"
                            @click="showOrderCard(item)"
                        >
                            <div class="text-nowrap small"
                                 v-if="item.user"
                            >
                                <router-link :to="{ name: 'users.update', params: { id: item.user.id } }">
                                    {{ item.user.name }}
                                </router-link>
                            </div>
                            <span v-else>-</span>
                        </td>
                    </tr>
                </template>
            </crm-data-table-pagination>

            <v-bottom-sheet
                inset fullscreen scrollable
                transition="slide-x-transition"
                elevation="0"
                v-model="showClientCard"
            >
                <client-card
                    :client="client"
                    :reload="showClientCard"
                    :hide="hideClientCard"
                    :getList="getClients"
                    @joinClient="joinClient"
                />
            </v-bottom-sheet>

        </template>
    </crm-default-listing-page>
</template>

<script>
import CrmDataTablePagination from "@/components/Common/Template/CrmDataTablePagination";
import CrmDefaultListingPage from "@/components/Common/Template/CrmDefaultListingPage";
import CrmDialog from "@/components/Common/Template/CrmDialog";
import ClientCard from "@/components/Pages/Dashboard/Clients/ClientCard";
import FilterForm from "@/components/Common/Filter";
import {cloneDeep as _cloneDeep} from 'lodash';
import {mapActions, mapGetters} from "vuex";
import ClientModel from "@/models/ClientModel";
import dateFormatter from "@/mixin/dateFormatter";
import categoryIcons from "@/mixin/categoryIcons";
import OrderCard from "@/components/Pages/Dashboard/Orders/Card";

export default {
    mixins: [dateFormatter,categoryIcons],

    components: {
        FilterForm,
        ClientCard,
        CrmDefaultListingPage,
        CrmDataTablePagination,
        CrmDialog,
        OrderCard,
    },

    data() {
        return {
            headers: [
                {
                    text: 'Угода',
                    align: 'start',
                    sortable: true,
                    value: 'order_id',
                },
                {
                    text: 'Тип угоди',
                    align: 'start',
                    sortable: true,
                    value: 'adv_type',
                },
                {
                    text: 'Клієнт',
                    align: 'start',
                    sortable: true,
                    value: 'fio',
                },
                {
                    text: 'Етап угоди',
                    align: 'start',
                    sortable: true,
                    value: 'stage_id',
                },
                {
                    text: 'Дата створення',
                    align: 'start',
                    sortable: true,
                    value: 'create_date',
                },
                {
                  text: 'Остання дія',
                  align: 'start',
                  sortable: true,
                  value: 'last_updated_date',
                }
            ],
            isShowTableSpinner: false,
            isShowDeleteDialog: false,
            isShowDeletionSpinner: false,
            itemsPerPageOptions: [10, 20, 30, 40, 50],
            itemsPerPageText: "Рядків на сторіку",
            itemsPerPageAllText: "Всі",

            itemToDelete: null,
            itemToDeleteProperty: 'fio',
            deleteItemTitle: 'угоду',
            deleteItemAct: 'order',
            totalClients: 0,
            options: {},

            filter: [
                {
                    field: 'radio',
                    value: null,
                    name: 'adv_types',
                    label: null,
                    permissions: null,
                    items: [],
                    width: null,
                },
                {
                    field: 'select',
                    value: null,
                    name: 'filterUser',
                    label: 'Агент',
                    disabled: false,
                    permissions: ['SuperAdmin', 'clients.viewAny'],
                    items: [],
                    width: null,
                    item: {text: 'name', value: 'id'}
                },
                {
                    field: 'select',
                    value: null,
                    name: 'clients',
                    label: 'Клієнт',
                    disabled: false,
                    permissions: null,
                    items: [],
                    width: null,
                    item: {text: 'fio', value: 'id'}
                },
                {
                    field: 'text',
                    value: '',
                    name: 'filterPhone',
                    label: 'Телефон',
                    permissions: null,
                    mask: '+38 (###) ###-####',
                    focus: '+38 (',
                    blur: 10,
                    width: null,
                },
                {
                    field: 'multiple',
                    value: null,
                    name: 'categories',
                    label: 'Тип нерухомості',
                    permissions: null,
                    items: [],
                    width: null,
                    item: {text: 'title', value: 'id'}
                },
                {
                    field: 'select',
                    value: null,
                    name: 'walls',
                    label: 'Матеріал стін',
                    disabled: false,
                    permissions: null,
                    items: [],
                    width: null,
                    item: {text: 'title', value: 'id'}
                },
                {
                    field: 'multiple',
                    value: null,
                    name: 'rooms',
                    label: 'Кількість кімнат',
                    permissions: null,
                    items: [],
                    width: null,
                    item: {text: 'title', value: 'id'}
                },
                {
                    field: 'multiple',
                    value: null,
                    name: 'floors.sell',
                    label: 'Поверх',
                    permissions: null,
                    items: [],
                    width: null,
                    item: {text: 'title', value: 'id'}
                },
                {
                    field: 'multiple',
                    value: null,
                    name: 'districts',
                    label: 'Райони',
                    permissions: null,
                    items: [],
                    width: {
                        cols: '12',
                        sm: '6',
                        md: '4',
                        lg: '2'
                    },
                    item: {text: 'title', value: 'id'}
                },
                {
                    field: 'text',
                    value: '',
                    name: 'price_to',
                    label: 'Ціна до',
                    width: {
                        cols: '12',
                        sm: '6',
                        md: '1',
                        lg: '1'
                    },
                    permissions: null
                },
                {
                    field: 'checkbox',
                    value: false,
                    name: 'free',
                    label: 'База клієнтів',
                    permissions: null
                },
                {
                  field: 'checkbox',
                  value: false,
                  name: 'archive',
                  label: 'Архів',
                  width: {
                    cols: '12',
                    sm: '6',
                    md: '1',
                    lg: '1'
                  },
                  permissions: ['SuperAdmin', 'clients.viewAny']
                },
            ],
            showOrderForm: false,
            showClientCard: false,
            client: _cloneDeep(ClientModel),
        };
    },

    computed: {
        ...mapGetters({
            getFilter: 'FilterModule/getFilter',
            dynprops: 'DynpropsModule/getDynprops',
            districts: 'DistrictsModule/getDistricts',
            getClientsList: 'ClientsModule/getClients',
            getAllUsersList: 'ClientsModule/getAllUsers',
        }),

        filters: {
            get() {
                return this.getFilter
            },
            set(value) {
                this.setFilter(value)
            }
        },

        computedObjectToBeWatched () {
            return this.filters && JSON.parse(JSON.stringify(this.filters));
        }
    },

    watch: {
        options: {
            handler(newValue, oldValue) {
                if (Object.keys(newValue).length !== 0) {
                    this.checkUrlParams();
                    this.getClients();
                }
            },
            deep: true,
        },

        computedObjectToBeWatched: {
            handler(newFilters, oldFilters) {
                if (Array.isArray(oldFilters)) {
                    const archiveNewFilter = this.filters.find(filter => filter.name === 'archive');
                    const freeNewFilter = this.filters.find(filter => filter.name === 'free');

                    const archiveOldFilter = oldFilters.find(filter => filter.name === 'archive');
                    const freeOldFilter = oldFilters.find(filter => filter.name === 'free');

                    if (archiveNewFilter && archiveNewFilter.value && (archiveNewFilter.value !== archiveOldFilter.value) && freeNewFilter) {
                        freeNewFilter.value = false;
                    }

                    if (freeNewFilter && freeNewFilter.value && (freeNewFilter.value !== freeOldFilter.value) && archiveNewFilter) {
                        archiveNewFilter.value = false;
                    }
                }
            },
            deep: true
        }
    },

    mounted() {
        this.setOrderCardCallback(this.getClients)

        if(!this.dynprops.stages) this.getDynprops()
        else this.setFilterDynprops()

        if(!this.districts.length) this.getDistricts()
        else this.setFilterDistricts()

        if(this.$auth.check(['SuperAdmin', 'clients.viewAny'] ,'permissions')) this.getUsers()
        if(this.$auth.check(['SuperAdmin', 'users.update'] ,'permissions')) this.headers.push({
            text: 'Користувач',
            align: 'start',
            sortable: true,
            value: 'user',
        })

        this.setFilter(this.filter)
    },

    methods: {
        ...mapActions({
            setFilter: 'FilterModule/setFilter',
            setDynprops: 'DynpropsModule/setDynprops',
            setDistricts: 'DistrictsModule/setDistricts',
            setClients: 'ClientsModule/setClients',
            setAllUsers: 'ClientsModule/setAllUsers',
            setOrder: 'OrderModule/setOrder',
			setCard: 'CardModule/setShow',
            setOrderCard: 'OrderCardModule/setShow',
            setOrderCardCallback: 'OrderCardModule/setCallback',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        handleShowOrderCard(e) {
            if (!e.target.classList.contains('open-client-card')
                && !e.target.parentElement.classList.contains('open-client-card'))
            {
                let item = this.getClientsList.find(item => item.id === Number(e.target.dataset.itemId))
                this.showOrderCard(item)
            }
        },

        clientCard(client) {
            this.client = client
            this.showClientCard = true
        },

        joinClient() {
            this.client.user_id = this.$auth.user().id
        },

        hideClientCard() {
            this.showClientCard = false
        },

        applyFilters() {
            this.options.page = 1;
            this.getClients();
        },

        resetFilters() {
            this.getFilter.forEach(item => {
                item.value = null
            })

            this.options.page = 1
            this.getClients()
        },

        checkUrlParams() {
          let queryString = window.location.search;
          let urlParams = new URLSearchParams(queryString);

          if(urlParams.has('free') && urlParams.get('free')){
            this.getFilter.find(item => item.name==='free').value = true
          }
        },

        getClients() {

            this.incrementSpinnerCounter()
            const {sortBy, sortDesc, page, itemsPerPage} = this.options

            let data = {
                sortBy: sortBy.length ? sortBy[0] : 'last_updated_date',
                sortDesc: sortDesc.length ? (sortDesc[0] ? 1 : 0) : null,
                page: page,
                itemsPerPage: itemsPerPage,
            }

            this.getFilter.forEach(item => {
                if(item.value) {
                    data[item.name.split('.')[0]] = item.value
                }
            })

            this.axios
                .get(`clients?`, {params: data})
                .then(response => {
                    this.setClients(response.data.data);
                    this.totalClients = response.data.count;
                })
                .catch(error => console.log(error))
                .finally(() => this.decrementSpinnerCounter())
        },

        getUsers() {
            this.incrementSpinnerCounter()
            this.axios
                .get(`clients/all-users`)
                .then(response => {
                    this.setAllUsers(response.data.data)

                    const defaultList = [
                        {
                            name: 'Без агента',
                            id: '-'
                        }
                    ];

                    this.filter.find(item => item.name==='filterUser').items = defaultList.concat(_cloneDeep(response.data.data))
                })
				.catch(error => console.log(error))
				.finally(() => this.decrementSpinnerCounter())
        },

        getDynprops() {
            this.incrementSpinnerCounter()

            this.axios
                .get(`dynprops`, {params:{withMyClients:true}})
                .then(response => {
                    this.setDynprops(response.data)
                })
                .then(() => {
                    this.setFilterDynprops()
                })
				.catch(error => console.log(error))
				.finally(() => this.decrementSpinnerCounter())
        },

        getDistricts() {
            this.incrementSpinnerCounter()

            let params = {
                city_id: 1,
                all: true
            }

            this.axios
                .get(`handbook/districts`, {params})
                .then(response => {
                    this.setDistricts(response.data)
                })
                .then(() => {
                    this.setFilterDistricts()
                })
				.catch(error => console.log(error))
                .finally(() => {
                    this.decrementSpinnerCounter()
                })
        },

        setFilterDynprops() {
            this.filter.forEach(item => {
                let name = item.name.split('.')
                if(name.length > 1) {
                    if(this.dynprops[ name[0] ][ name[1] ]) item.items = this.dynprops[ name[0] ][ name[1] ]
                } else {
                    if(this.dynprops[name[0]]) item.items = this.dynprops[name[0]]
                }
            })
        },

        setFilterDistricts() {
            this.filter.find(item => { if(item.name==='districts') item.items = this.districts })
        },

        showOrderCard(item) {
          if(item.order.id) {
            let order = item.order
            order.client = item
            order.client.phone_numbers = item.phoneNumbers

            this.setOrder(order)
            this.setCard(true)
            this.setOrderCard(true)
          }
        },

        getStageTitle(stageId) {
            let stage = this.dynprops.stages.find(stage => stage.id === stageId)
            return stage.title
        }

    }
}
</script>

<style scoped lang="scss">
.controls {
    min-width: 100px;
    width: 100px;
}
.alert-phone {
    padding: 5px 10px;
    font-size: 14px;
}
.table-phone-number {
    min-width: 220px;
}
</style>
<style>
.closed-order {
    opacity: 0.4 !important;
}
</style>
