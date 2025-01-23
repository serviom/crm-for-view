<template>
    <div>
        <div v-if="((stageChanged || (oldStage || newStage)) && !cancel)"
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
            <div class="d-flex ml-3"
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
            <v-col cols="10" md="11" class="mt-5 mb-0 py-0">
                <v-select
                    v-if="newStage && newStage.is_last"
                    v-model="comment"
                    :items="lastStageComments"
                    label="Коментар"
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
                ></v-textarea>
            </v-col>
            <v-col cols="2" md="1" class="mb-0 pl-0 pr-2 pt-5 pb-0 d-flex justify-content-end">
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
</template>

<script>
import {mapActions} from "vuex";
import reminder from "@/mixin/reminder";
import requestMethods from '@/mixin/requestMethods'
import {isEmpty as _isEmpty} from 'lodash';

export default {
    name: "CommentForm",
    mixins: [reminder, requestMethods],
    props: {
        entity: {
            type: String,
            required: true
        },
        message: {
            type: String,
            default: ''
        },
        id: {
            type: Number,
            required: true
        },
        clientID: {
            type: Number
        },
        saveOrder: {
            type: Function,
            default: ()=>{}
        },
        stageChangedToggle: {
            type: Function,
            default: ()=>{}
        },
        stageChanged: {
            type: Boolean,
            default: false
        },
        cancel: {
            type: Boolean,
            default: false
        },
        oldStage: {
            type: Object
        },
        newStage: {
            type: Object
        },
        dateTime: {
            type: Object,
            default: ()=>{return {}}
        },
        callback: {
            type: Function,
            default: ()=>{}
        },
    },
    watch: {
        stageChanged: {
            handler(newValue, oldValue) {
                if (newValue) {
                    this.$refs.comment.focus()
                }
            },
        },
        newStage: {
            handler(newValue, oldValue) {
                if (newValue) {
                    if(newValue.id){
                        let {date, time} = this.getTime(newValue)
                        this.date = date
                        this.time = time
                    } else {
                        let {date, time} = this.getTime(this.oldStage)
                        this.date = date
                        this.time = time
                    }
                }
            },
        },
    },
    data() {
        return {
            rules: {
                maxLength: len => v => (v || '').length <= len || `Невірна довжина коментаря, має бути не більше ${len}`,
            },
            comment: this.message,
            date: this.dateTime && this.dateTime.date ? this.dateTime.date : this.getTime().date,
            time: this.dateTime && this.dateTime.time ? this.dateTime.time : this.getTime().time,
            calendar: false,
            timepicker: false,
            oldStageIsEmpty: _isEmpty(this.oldStage),
            lastStageComments: [
                'Купив з нами',
                'Купив без нас',
                'Не актуально'
            ]
        };
    },
    methods: {
        ...mapActions({
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        allowedMinutesStep: m => m % 5 === 0,

        addComment(){
			this.incrementSpinnerCounter()

			let data = {
				client_id: this.clientID,
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

			this.add_comment(this.entity, this.id, data, ()=>{
				this.comment = ''
				if(this.stageChanged) {
					this.stageChangedToggle()
					this.saveOrder()
				}
				this.callback()
			})

			this.decrementSpinnerCounter()
        },
    }
}
</script>

<style scoped>
.stage-item {
    text-overflow: ellipsis;
    overflow: hidden;
}
</style>
<style>
.v-date-picker-table {
    height: auto;
}
</style>
