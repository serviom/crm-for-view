<template>
    <v-card :outlined="!buttons" :class="buttons ? '' : 'pb-8 no-border'" :id="'order-form-'+temp.id">
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <div>
                <div class="d-flex align-items-center justify-content-between">
                    <v-card-title v-bind:class="temp.id ? 'pb-3' : 'pb-0'" class="pt-4 px-5 px-md-8">{{ temp.id ? 'Редагування угоди' : 'Нова угода'}}</v-card-title>

                    <v-card-actions class="pt-3 pb-0 px-8 d-flex justify-content-between" v-if="buttons">
                        <v-btn
                            color="grey"
                            text
                            icon
                            @click="toggleDialog"><v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-btn
                            :disabled="!valid"
                            color="success"
                            @click="saveOrder">Зберегти
                        </v-btn>
                    </v-card-actions>
                </div>
            </div>

            <v-card-text class="px-5 px-md-8">
                <v-row align="center">
                    <v-col cols="12" class="my-0 pb-0 form-inline">
                        <v-radio-group
                            class="mt-0"
                            v-model="temp.adv_type"
                            row
                            required
                            :rules="[rules.required]"
                            :disabled="!!temp.id"
                        >
                            <v-radio
                                class="radio-adv_type"
                                :label="type"
                                :value="type"
                                v-for="(type, i) in dynprops.adv_types"
                                :key="i"
                                @change="checkOrder"
                            ></v-radio>
                        </v-radio-group>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0">
                        <v-select
                            dense
                            required
                            :rules="[rules.required]"
                            v-model="temp.stage_id"
                            :items="dynprops.stages"
                            item-text="title"
                            item-value="id"
                            label="Етап угоди"
                            @input="checkOrder"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0 d-none"

                           v-if="1===0"

                    >
                        <v-select
                            dense
                            required
                            :rules="[rules.required]"
                            v-model="temp.city_id"
                            :items="cities"
                            item-text="title"
                            item-value="id"
                            label="Місто"
                            @input="checkOrder"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0">
                        <v-select
                            dense
                            required
                            :rules="[rules.required]"
                            v-model="temp.category"
                            :items="dynprops.categories"
                            label="Тип нерухомості"
                            elevation="3"
                            @input="checkOrder"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" class="mb-0 pt-0 pb-0" v-if="temp.adv_type !== 'Продаж'">
                        <v-autocomplete
                            v-model="temp.districts"
                            :items="districts"
                            chips
                            color="blue-grey lighten-2"
                            label="Район"
                            item-text="title"
                            item-value="id"
                            multiple
                            @input="checkOrder"
                        >
                            <template v-slot:selection="data">
                                <v-chip
                                    v-bind="data.attrs"
                                    :input-value="data.selected"
                                    close
                                    @click="data.select"
                                    @click:close="remove(data.item)"
                                >
                                    {{ data.item.title }}
                                </v-chip>
                            </template>
                            <template v-slot:item="data">
                                <template v-if="typeof data.item !== 'object'">
                                    <v-list-item-content v-text="data.item"></v-list-item-content>
                                </template>
                                <template v-else>
                                    <v-list-item-content>
                                        <v-list-item-title v-html="data.item.title"></v-list-item-title>
                                    </v-list-item-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0" v-if="temp.adv_type === 'Продаж'">
                        <v-text-field
                            dense
                            v-model="temp.street"
                            label="Вулиця"
                            @input="checkOrder"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" md="3" class="mb-0 pb-0" v-if="temp.adv_type === 'Продаж'">
                        <v-text-field
                            dense
                            v-model="temp.house_number"
                            label="№ будинку"
                            @input="checkOrder"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" md="3" class="mb-0 pb-0" v-if="temp.adv_type === 'Продаж'">
                        <v-text-field
                            dense
                            v-model="temp.apartment_number"
                            label="№ квартири"
                            @input="checkOrder"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0" v-show="temp.category !== 'Ділянка'">
                        <v-select
                            dense
                            v-model="temp.type"
                            :items="dynprops.build_types"
                            label="Вид об'єкта"
                            @input="checkOrder"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0" v-show="temp.category !== 'Ділянка'">
                        <v-select
                            dense
                            v-model="temp.repair"
                            :items="dynprops.repairs"
                            label="Ремонт"
                            @input="checkOrder"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0">
                        <v-text-field
                            dense
                            required
                            :rules="[rules.required]"
                            v-model="temp.price"
                            :label="temp.adv_type==='Продаж' ? 'Ціна' : 'Ціна до'"
                            @input="checkOrder"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0" v-show="temp.category !== 'Ділянка'">
                        <v-select
                            dense
                            v-model="temp.walls"
                            :items="dynprops.walls"
                            item-text="title"
                            item-value="id"
                            label="Матеріал стін"
                            @input="checkOrder"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pb-0" v-show="(temp.category === 'Квартира' || temp.category === 'Кімната')">
                        <v-autocomplete
                            v-model="temp.floors"
                            :items="dynprops.floors.sell"
                            chips multiple
                            color="blue-grey lighten-2"
                            label="Поверх"
                            item-text="title"
                            item-value="id"
                            @input="checkOrder"
                        >
                            <template v-slot:selection="data">
                                <v-chip
                                    v-bind="data.attrs"
                                    :input-value="data.selected"
                                    @click="data.select"
                                    @click:close="remove(data.item)"
                                >
                                    {{ data.item.title }}
                                </v-chip>
                            </template>
                            <template v-slot:item="data">
                                <template v-if="typeof data.item !== 'object'">
                                    <v-list-item-content v-text="data.item"></v-list-item-content>
                                </template>
                                <template v-else>
                                    <v-list-item-content>
                                        <v-list-item-title v-html="data.item.title"></v-list-item-title>
                                    </v-list-item-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="6" class="mb-0 pt-0 pb-0" v-show="(temp.category !== 'Ділянка' && temp.category !== 'Кімната')">
                        <v-autocomplete
                            :rules="[rules.required]"
                            v-model="temp.rooms"
                            :items="dynprops.rooms"
                            chips multiple
                            color="blue-grey lighten-2"
                            label="Кількість кімнат"
                            item-text="title"
                            item-value="id"
                            @input="checkOrder"
                        >
                            <template v-slot:selection="data">
                                <v-chip
                                    v-bind="data.attrs"
                                    :input-value="data.selected"
                                    @click="data.select"
                                    @click:close="remove(data.item)"
                                >
                                    {{ data.item.title }}
                                </v-chip>
                            </template>
                            <template v-slot:item="data">
                                <template v-if="typeof data.item !== 'object'">
                                    <v-list-item-content v-text="data.item"></v-list-item-content>
                                </template>
                                <template v-else>
                                    <v-list-item-content>
                                        <v-list-item-title v-html="data.item.title"></v-list-item-title>
                                    </v-list-item-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-form>

        <div class="v-card__text px-5 px-md-8 pt-0" v-if="temp.id">
            <v-col cols="12" class="comments-block pb-5">

				<div>
					<div
						v-if="((stageChanged || (oldStage || newStage)) && !cancel)"
						class="d-flex justify-content-between align-items-center pt-3"
					>
						<v-chip small
								color="#f4433636"
								class="stage-line-item"
						>
							<span v-if="oldStage" v-text="oldStage.title" class="stage-item"></span>
							<v-icon v-if="newStage && newStage.title" class="mx-3" color="red">mdi-ray-start-arrow</v-icon>
							<span v-if="newStage && newStage.title" v-text="newStage.title" class="stage-item"></span>
						</v-chip>
						<div
							class="d-flex ml-3"
							v-if="!newStage.is_last"
						>
							<v-dialog
								ref="dialog"
								v-model="calendar"
								persistent
								width="290px"
							>
								<template v-slot:activator="{ on, attrs }">
									<v-chip
										v-bind="attrs"
										v-on="on"
										small link
										class="stage-line-item"
									>{{ date }} <v-icon x-small right>mdi-calendar-month</v-icon></v-chip>
								</template>
								<v-date-picker
									v-model="date"
									@input="calendar = false"
									locale="uk"
									scrollable
								>
									<v-spacer></v-spacer>
									<v-btn
										text
										color="primary"
										@click="calendar = false"
									>Закрити</v-btn>
								</v-date-picker>
							</v-dialog>

							<v-dialog
								ref="timepicker"
								v-model="timepicker"
								:return-value.sync="time"
								persistent
								width="290px"
							>

								<template v-slot:activator="{ on, attrs }">
									<v-chip
										v-bind="attrs"
										v-on="on"
										small link
										class="stage-line-item ml-2"
									>{{ time }} <v-icon x-small right>mdi-calendar-clock</v-icon></v-chip>
								</template>
								<v-time-picker
									v-if="timepicker"
									v-model="time"
									format="24hr"
									:allowed-minutes="allowedMinutesStep"
									full-width
									@click:minute="$refs.timepicker.save(time)"
								>
									<v-spacer></v-spacer>
									<v-btn
										text
										color="primary"
										@click="timepicker = false"
									>Закрити</v-btn>
								</v-time-picker>
							</v-dialog>

						</div>
					</div>
					<v-row align="center" class="pb-4">
						<v-col
							:cols="stageChanged ? '12' : '10'"
							:md="stageChanged ? '12' : '11'"
							class="mt-5 mb-0 py-0"
						>
							<v-select
								v-if="newStage && newStage.is_last"
								v-model="comment"
								:items="lastStageComments"
								label="Коментар"
								id="comment-form-select"
							></v-select>

							<v-textarea
								v-else
								ref="comment"
								label="Коментар"
								v-model="comment"
								rows="1"
								auto-grow
								counter="1500"
								:rules="[rules.maxLength(1500)]"
								:error="(stageChanged || !oldStageIsEmpty || cancel)"
								:messages="stageChanged ? ['Зміна статусу, коментар обов`язковий'] : (cancel ? ['Архівування угоди, коментар обов`язковий'] : (!oldStageIsEmpty ? ['Коментар обов`язковий'] : []))"
								class="mb-0 pb-0"
								id="comment-form-input"
							></v-textarea>
						</v-col>
						<v-col
							v-if="!stageChanged"
							cols="2"
							md="1"
							class="mb-0 pl-0 pr-2 pt-5 pb-0 d-flex justify-content-end"
						>
							<v-tooltip
								bottom color="info"
							>
								<template v-slot:activator="{ on, attrs }">
									<v-btn
										color="info"
										class="white--text mr-1"
										fab x-small
										@click="addComment"
										v-bind="attrs"
										v-on="on"
									>
										<v-icon>mdi-check</v-icon>
									</v-btn>
								</template>
								<span>Додати коментар</span>
							</v-tooltip>
						</v-col>
					</v-row>
				</div>

            </v-col>
            <comments-list
                entity="order"
                :id="temp.id"
                :reload="reloadComments"
            />
        </div>
        <div class="v-card__text px-5 px-md-8 pt-0" v-else>
            <v-textarea
                label="Коментар"
                v-model="temp.comment"
                rows="3"
                auto-grow
                counter="1500"
                :rules="[rules.maxLength(1500)]"
                class="mb-0 pb-0"
            ></v-textarea>
        </div>
    </v-card>
</template>

<script>

import {mapActions, mapGetters} from "vuex";
import reminder from "@/mixin/reminder";
import requestMethods from '@/mixin/requestMethods'
import CommentsList from "@/components/Pages/Dashboard/Comments/CommentsList";
import {isEmpty as _isEmpty} from "lodash";

export default {
    name: "OrderForm",
    mixins: [reminder, requestMethods],
    components: {CommentsList},
    props: {
        toggleDialog: {
            type: Function
        },
        callback: {
            type: Object,
            default: ()=>{ return {
					incrementComments:()=>{},
					cancelOrderForm:()=>{}
				}
			}
        },
        item: {
            type: Object
        },
        buttons: {
            type: Boolean
        }
    },
    watch: {
        temp: {
            handler(newValue, oldValue) {
                if(this.item.id) {
                    this.oldStage = null
                    this.newStage = null

                    if (
						Object.keys(newValue).length !== 0
                        && this.itemID === this.temp.id
					) {
                        this.stageChanged = this.stage !== this.temp.stage_id

                        if(this.stageChanged){
                            this.oldStage = this.dynprops.stages.find(item => item.id === this.stage)
                            this.newStage = this.dynprops.stages.find(item => item.id === this.temp.stage_id)

							let stageTime = this.getTime(this.newStage)

							this.date = stageTime.date
							this.time = stageTime.time
                        }
                    } else {
                        this.itemID = this.temp.id
                        this.stage = this.temp.stage_id
                        this.stageChanged = false
                    }
                }
            },
            deep: true,
        },
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
            valid: true,
            temp: this.item,
            cityID: null,
            reloadComments: 0,
            itemID: this.item.id,
            stage: this.item.stage_id,
            stageChanged: false,
            oldStage: null,
            newStage: null,

			comment: '',
			cancel: false,
			calendar: false,
			timepicker: false,
			date: this.getTime().date,
			time: this.getTime().time,
			oldStageIsEmpty: _isEmpty(this.oldStage),
			lastStageComments: [
				'Купив з нами',
				'Купив без нас',
				'Не актуально'
			],
        };
    },
    computed: {
        ...mapGetters({
            cities: 'CitiesModule/getCities',
            districts: 'DistrictsModule/getDistricts',
            dynprops: "DynpropsModule/getDynprops",
        }),
    },
    async mounted() {
        if(!this.dynprops.stages) await this.getDynprops()
        else if(!this.temp.stage_id) this.temp.stage_id = this.dynprops.stages[0].id

        if(!this.cities.length) await this.getCities()
        else if(!this.temp.city_id) this.temp.city_id = this.cities[0].id

        if(!this.districts.length) await this.getDistricts()
    },
    methods: {
        ...mapActions({
            setCities: 'CitiesModule/setCities',
            setDistricts: 'DistrictsModule/setDistricts',
            setDynprops: 'DynpropsModule/setDynprops',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),
        remove (item) {
            const index = this.temp.districts.indexOf(item.id)
            if (index >= 0) this.temp.districts.splice(index, 1)
        },
        checkOrder() {
            if(! this.buttons) {
                this.saveOrder()
            }
            if(this.temp.city_id !== this.cityID) {
                this.cityID = this.temp.city_id
                this.getDistricts()
            }
        },
        saveOrder() {
            let valid = this.$refs.form.validate()

            if (valid) {
                if(this.stageChanged) {
					if(this.temp.id) {
						if(this.comment) {
							this.addComment()
						} else {
							let message = 'Ви не додали коментар після зміни статусу! Коментар обов`язковий!'
							this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 7000)
							return;
						}
					}
                }

				this.stage = this.temp.stage_id
				this.stageChanged = false
				this.$emit('saveOrder', this.temp)
            }
        },
        cancelOrder() {
            this.toggleDialog()
            this.callback.cancelOrderForm()
        },
        getCities() {
            this.incrementSpinnerCounter()
            this.axios
                .get(`handbook/cities`, {})
                .then(response => {
                    this.setCities(response.data.data)
                })
                .then(() => {
                    if(!this.temp.city_id) this.temp.city_id = this.cities[0].id
                })
                .catch(error => console.log(error))
                .finally(() => this.decrementSpinnerCounter())
        },
        getDistricts() {
            this.incrementSpinnerCounter()

            let params = {
                city_id: this.cityID ? this.cityID : (this.temp.city_id ? this.temp.city_id : 1),
                all: true
            }

            this.axios
                .get(`handbook/districts`, {params})
                .then(response => {
                    this.setDistricts(response.data)
                })
                .catch(error => console.log(error))
                .finally(() => this.decrementSpinnerCounter());
        },
        getDynprops() {
            this.incrementSpinnerCounter()

            this.axios
                .get(`dynprops`, {})
                .then(response => {
                    this.setDynprops(response.data)
                })
                .then(() => {
                    if(!this.temp.stage_id) this.temp.stage_id = this.dynprops.stages[0].id
                })
				.catch(error => console.log(error))
                .finally(() => this.decrementSpinnerCounter())
        },
        incrementComments(){
            this.reloadComments += 1
            this.callback.incrementComments()
        },
		allowedMinutesStep: m => m % 5 === 0,
		addComment(){
			this.incrementSpinnerCounter()

			let data = {
				client_id: this.temp.client.id,
				order_id: this.temp.id,
				comment: this.comment,
				stage: null
			}
			if(this.stageChanged) {
				data.stage = {
					old: this.oldStage,
					new: this.newStage,
					date: this.date,
					time: this.time,
				}
			} else if(this.oldStage) {
				data.stage = {
					old: this.oldStage,
				}
			}

			this.add_comment('order', this.temp.id, data, ()=>{
				this.comment = ''
				this.incrementComments()
			})

			this.decrementSpinnerCounter()
		},
    }
}
</script>

<style scoped>
.no-border {
    border: none  !important;
}
.radio-adv_type {
    margin-right: 10px !important;
}
.radio-adv_type:last-child {
    margin-right: 0 !important;
}
.comments-block {
    background-color: rgba(0,0,0,0.03);
}
</style>
