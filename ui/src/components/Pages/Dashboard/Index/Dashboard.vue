<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" sm="6" md="4" lg="3">
                <router-link :to="{ name: 'objects'}">
                    <v-card
                        class="mx-auto"
                        outlined
                        color="light-blue"
                        dark
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div>
                                    <v-list-item-title class="text-h5 mb-1">
                                        {{ dashboard.objectsCount }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle>Об'єкти</v-list-item-subtitle>
                                </div>
                                <v-card-actions class="p-0">
                                    <v-btn
                                        outlined
                                        rounded
                                        text
                                    >
                                        Всі
                                    </v-btn>
                                </v-card-actions>
                            </v-list-item-content>

                            <v-list-item-avatar
                                tile
                                size="120"
                            >
                                <v-icon
                                    size="120"
                                >mdi-office-building-marker</v-icon>
                            </v-list-item-avatar>
                        </v-list-item>
                    </v-card>
                </router-link>
            </v-col>
            <v-col
				v-if="$auth.check(['SuperAdmin', 'users.viewAny'] ,'permissions')"
				cols="12" sm="6" md="4" lg="3"
			>
                <router-link :to="{ name: 'users'}">
                    <v-card
                        class="mx-auto"
                        outlined
                        color="cyan"
                        dark
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div>
                                    <v-list-item-title class="text-h5 mb-1">
                                        {{ dashboard.usersCount }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
										<span
											v-if="$auth.check(['SeniorAgent'] ,'permissions')"
										>Мої агенти</span>
										<span v-else>Користувачі</span>
									</v-list-item-subtitle>
                                </div>
                                <v-card-actions class="p-0">
                                    <v-btn
                                        outlined
                                        rounded
                                        text
                                    >
                                        Всі
                                    </v-btn>
                                </v-card-actions>
                            </v-list-item-content>

                            <v-list-item-avatar
                                tile
                                size="120"
                            >
                                <v-icon
                                    size="120"
                                >mdi-account-multiple</v-icon>
                            </v-list-item-avatar>
                        </v-list-item>
                    </v-card>
                </router-link>
            </v-col>
            <v-col cols="12" sm="6" md="4" lg="3">
                <router-link :to="{ name: 'clients'}">
                    <v-card
                        class="mx-auto"
                        outlined
                        color="teal"
                        dark
                    >
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div>
                                    <v-list-item-title class="text-h5 mb-1">
                                        {{ dashboard.clientsCount }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
										<span
											v-if="$auth.check(['SuperAdmin'] ,'permissions')"
										>Клієнти</span>
										<span v-else>Мої клієнти</span>
									</v-list-item-subtitle>
                                </div>
                                <v-card-actions class="p-0">
                                    <v-btn
                                        class="mr-3"
                                        outlined
                                        rounded
                                        text
                                    >
                                        Всі
                                    </v-btn>
                                </v-card-actions>
                            </v-list-item-content>

                            <v-list-item-avatar
                                tile
                                size="120"
                            >
                                <v-icon
                                    size="120"
                                >mdi-briefcase-account</v-icon>
                            </v-list-item-avatar>
                        </v-list-item>
                    </v-card>
                </router-link>
            </v-col>
			<v-col cols="12" sm="6" md="4" lg="3">
				<router-link :to="{ name: 'clients', query: { free: 1 }}">
					<v-card
						class="mx-auto"
						outlined
						color="cyan"
						dark
					>
						<v-list-item three-line>
							<v-list-item-content>
								<div>
									<v-list-item-title class="text-h5 mb-1">
										{{ dashboard.freeClientsCount }}
									</v-list-item-title>
									<v-list-item-subtitle>База клієнтів</v-list-item-subtitle>
								</div>
								<v-card-actions class="p-0">
									<v-btn
										class="mr-3"
										outlined
										rounded
										text
									>
										Всі
									</v-btn>
								</v-card-actions>
							</v-list-item-content>

							<v-list-item-avatar
								tile
								size="120"
							>
								<v-icon
									size="120"
								>mdi-briefcase-account</v-icon>
							</v-list-item-avatar>
						</v-list-item>
					</v-card>
				</router-link>
			</v-col>
        </v-row>

        <v-divider class="my-8"></v-divider>

        <div class="mw-100 overflow-hidden stage-container">
            <v-row
                v-if="dashboard.orders && dashboard.orders.count"
                class="w-auto flex-nowrap overflow-auto stage-row"
            >
                <v-col
                    v-for="(item, i) in dashboard.orders.data"
                    :key="i"
                    :class="'stage-col-container ' + (item.items.length ? 'col-sm-6 col-md-4 col-lg-3 col-12' : 'col-3 col-md-1 without-items')"
                >
                    <v-card
                        class="w-100 pa-0 stage-col d-flex flex-column"
                        outlined
                    >
                        <v-card-title class="col-card__title">{{ item.title }}</v-card-title>
                        <div
                            v-if="item.items.length"
                            class="orders-list h-100"
                        >
                            <order
                                v-for="(order, k) in item.items"
                                :key="(k+1)"
                                :order="order"
                                :callback="showOrderCard"
                                class="mb-4"
                            />
                        </div>
                    </v-card>
                </v-col>
            </v-row>

            <div v-else-if="!isShowSpinner"
                class="d-flex justify-content-center align-items-center w-100 vh-30 bg-light"
            >Список угод пустий</div>
        </div>

    </v-container>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {cloneDeep as _cloneDeep} from 'lodash';
import Order from "@/components/Pages/Dashboard/Orders/Order";
import OrderCard from "@/components/Pages/Dashboard/Orders/Card";
import OrderForm from "@/components/Pages/Dashboard/Orders/Form";
import CrmDialog from "@/components/Common/Template/CrmDialog";
import dateFormatter from "@/mixin/dateFormatter";
import OrderModel from "@/models/OrderModel";
import CommentForm from "@/components/Pages/Dashboard/Comments/CommentForm";

export default {
    name: 'Dashboard',
    mixins: [dateFormatter],
    components: {Order, OrderForm, OrderCard, CrmDialog, CommentForm},
    data() {
        return {
            isShowDeletionSpinner: false,
            itemToDelete: null,
            reloadComments: 0,
            showOrderForm: false,
            temp: _cloneDeep(OrderModel)
        };
    },
    computed: {
        ...mapGetters({
            isShowSpinner: 'SpinnerModule/isShowSpinner',
            dashboard: 'DashboardModule/getDashboard',
            dynprops: 'DynpropsModule/getDynprops',
            districts: 'DistrictsModule/getDistricts',
            order: 'OrderModule/getOrder',
        }),
    },
    mounted() {
        if(!this.dynprops.stages) this.getDynprops()
        if(!this.districts.length) this.getDistricts()
        this.setOrderCardCallback(this.getDashboardData)
        this.getDashboardData()
    },
    methods: {
        ...mapActions({
            setDashboard: 'DashboardModule/setDashboard',
            setDynprops: 'DynpropsModule/setDynprops',
            setDistricts: 'DistrictsModule/setDistricts',
            setStages: 'StageModule/setList',
            setOrder: 'OrderModule/setOrder',
            setCard: 'CardModule/setShow',
			setOrderCard: 'OrderCardModule/setShow',
            setOrderCardCallback: 'OrderCardModule/setCallback',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        getDynprops() {
            this.incrementSpinnerCounter()
            this.axios
                .get(`dynprops`, {params:{withMyClients:true}})
                .then(response => {
                    this.setDynprops(response.data)
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
              .catch(error => console.log(error))
              .finally(() => this.decrementSpinnerCounter())
        },

        async getDashboardData() {
            this.incrementSpinnerCounter()
            await this.axios
                .get(`dashboard`)
                .then(response => {
                    this.setDashboard(response.data.data);
                })
                .catch(error => console.log(error))
                .finally(() => this.decrementSpinnerCounter())
        },

        showOrderCard(item) {
            this.setOrder(item)
			this.setCard(true)
            this.setOrderCard(true)
        },

        incrementComments(){
            this.reloadComments += 1
        },
    }
}
</script>

<style scoped>
.stage-container {
    padding-bottom: 15px;
}
.stage-row {
    /*padding: 10px;*/
}
.stage-col-container {
    max-width: 330px;
    overflow: hidden;
}
.stage-col {
    background-color: rgba(9,30,66,0.03);
    height: 100%;
    border: none;
}
.col-card__title {
    font-size: 1rem;
    padding: 8px;
    background-color: rgba(9,30,66,0.09);
    text-align: center;
    word-break: break-word;
    word-wrap: break-word;
}
.without-items .stage-col {
    background-color: rgba(9,30,66,0.03);
    border: 2px dashed rgba(9,30,66,0.09);
}
.without-items .col-card__title {
    opacity: 0.5;
    background-color: transparent;
    padding: 12px;
    text-align: inherit;
    display: flex;
    width: 100%;
    white-space: nowrap;
    writing-mode: vertical-lr;
}
.stage-col .orders-list {
    padding: 20px 15px 15px;
    border: 2px solid rgba(9,30,66,0.09);
    border-top: 0;
}
@media (max-width: 767px) {
    .without-items .col-card__title {
        padding: 12px 4px;
    }
}
</style>
<style>
.stage-col-container .order-item.blue:hover,
.stage-col-container .order-item.blue:focus {
    background-color: #2196f3d9 !important;
}
.stage-col-container .order-title {
    font-size: 1rem !important;
    line-height: 1.7rem;
    margin-left: 0 !important;
}
.stage-col-container .order-client {
    font-size: 12px;
    color: #999;
    padding-left: 8px;
    margin-top: 4px;
}
.stage-col-container .theme--dark .order-client {
    color: inherit;
}
.stage-col-container .theme--dark .order-phone {
    color: #fff;
    /*text-decoration: underline !important;*/
}
.stage-col-container .order-title-container {
    padding: 8px 16px 8px 8px !important;
}
.stage-col-container .order-body-container {
    padding: 0 8px 8px !important;
}
.order-bottom-container .v-card__text {
    padding: 12px;
}
.stage-col-container .order-bottom-buttons {
    padding: 0 4px 8px !important;
}
.stage-col-container .order-bottom-chip {
    padding: 15px 12px 0 !important;
    flex-wrap: wrap;
}
.stage-col-container .order-bottom-chip .v-chip {
    margin-top: 0 !important;
    margin-bottom: 8px !important;
}
.vh-30 {
    height: 30vh;
}
</style>
