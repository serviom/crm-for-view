<template>
    <v-card
        class="mb-4" :class="{'closed':offer.archive}"
        :loading="saveOfferId === offer.id"
    >
        <div class="w-100 d-flex flex-no-wrap justify-space-between overflow-hidden">
            <div class="d-flex flex-column justify-space-between pa-2 pr-0">
                <v-hover v-slot="{ hover }" class="cursor-pointer d-none">
                    <v-icon v-if="hover" dense>mdi-menu-swap-outline</v-icon>
                    <v-icon v-else dense>mdi-menu</v-icon>
                </v-hover>

                <v-tooltip right color="primary">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon x-small
                            v-bind="attrs"
                            v-on="on"
                            @click="archiveOffer(offer)"
                        >
                            <v-hover v-slot="{ hover }">
                                <v-icon v-if="hover" color="primary">mdi-archive</v-icon>
                                <v-icon v-else>mdi-archive</v-icon>
                            </v-hover>
                        </v-btn>
                    </template>
                    <span v-if="offer.archive">З архіву</span>
                    <span v-else>В архів</span>
                </v-tooltip>
            </div>

            <v-avatar
                tile size="60"
                class="ma-2 border-radius-2"
                style="background-color:#f5f5f5;"
            >
                <v-img
                    v-if="offer.img"
                    :src="offer.img"
                ></v-img>
<!--                <v-icon-->
<!--                    v-else-->
<!--                >mdi-home-city-outline-->
<!--                </v-icon>-->
            </v-avatar>

            <v-card-text class="pa-2 d-flex align-items-center">
                <v-row>
                    <v-col cols="12" md="6"
                           class="pt-0 pt-md-3 order-1 order-md-0 d-flex flex-md-column justify-content-between pr-0 pr-md-3"
                           :class="offer.comment ? '' : 'flex-column'"
                           v-if="showOfferCommentForm !== offer.id"
                    >
                        <a :href="offer.link" target="_blank"
                        >{{ offer.domain }}
                            <v-icon color="info" x-small>mdi-open-in-new</v-icon>
                        </a>
                        <div style="margin-right:-5px">
                            <span class="d-none d-md-inline mr-2">Показ:</span>

                            <v-chip x-small
                                    class="ma-0 py-1 px-2 cursor-pointer"
                                    @click="showOfferDate(offer)"
                                    :color="offer.show_date && !offer.archive ? 'info' : ''"
                            >
                                <v-icon small class="d-inline d-md-none mr-1" style="margin-left:-5px">mdi-eye</v-icon>
                                {{ offer.show_date ? offer.show_date : 'Не запланований' }}
                            </v-chip>
                        </div>
                    </v-col>
                    <v-col cols="12" :md="showOfferCommentForm === offer.id ? 12 : 6"
                           class="order-0 order-md-1"
                    >
                        <div v-if="showOfferCommentForm === offer.id" class="h-100">
                            <v-textarea
                                v-model="offer.comment"
                                label="Коментар"
                                hide-details autofocus
                                outlined dense auto-grow
                                rows="2" row-height="1"
                                class="offer-comment-form"
                            ></v-textarea>
                        </div>
                        <div v-else class="h-100 d-flex flex-column justify-content-between">
                            <div>
								<v-tooltip
									v-if="offer.comment && offer.comment.length > 45"
									bottom max-width="300"
								>
									<template v-slot:activator="{ on, attrs }">
										<span
											v-bind="attrs"
											v-on="on"
											class="offer-comment"
										>
											{{ offer.comment }}
										</span>
									</template>
									<span>{{ offer.comment }}</span>
								</v-tooltip>
								<span v-else class="offer-comment">
									{{ offer.comment }}
								</span>
							</div>

							<div class="fs-12 grey--text">{{ offer.created }}</div>
                        </div>
                    </v-col>
                </v-row>
                <div class="d-flex flex-column justify-space-between h-100">
                    <div>
                        <v-tooltip top color="primary" v-if="showOfferCommentForm === offer.id">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon x-small
                                    v-bind="attrs"
                                    v-on="on"
                                    class="comment-button"
                                    @click="saveOfferComment(offer)"
                                >
                                    <v-icon>mdi-check</v-icon>
                                </v-btn>
                            </template>
                            <span v-text="'Зберегти'"></span>
                        </v-tooltip>

                        <v-tooltip top color="primary" v-else>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon x-small
                                    v-bind="attrs"
                                    v-on="on"
                                    class="comment-button"
                                    @click="editOfferComment(offer)"
                                >
                                    <v-icon v-if="offer.comment">mdi-file-document-edit-outline</v-icon>
                                    <v-icon v-else>mdi-file-document-outline</v-icon>
                                </v-btn>
                            </template>
                            <span v-text="(offer.comment ? 'Редагувати коментар' : 'Додати коментар')"></span>
                        </v-tooltip>
                    </div>

                    <v-tooltip top color="primary" v-if="showOfferCommentForm === offer.id">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                icon x-small
                                v-bind="attrs"
                                v-on="on"
                                @click="showCommentVariants(offer.id)"
                            >
                                <v-hover v-slot="{ hover }">
                                    <v-icon v-if="hover" color="primary">mdi-book-multiple</v-icon>
                                    <v-icon v-else>mdi-book-multiple</v-icon>
                                </v-hover>
                            </v-btn>
                        </template>
                        <span>Швидкі варіанти</span>
                    </v-tooltip>
                </div>
            </v-card-text>
        </div>

        <v-expand-transition>
            <div
                class="text-right"
                v-show="showCommentReadyVariants === offer.id"
            >
                <v-divider class="my-1"></v-divider>

                <v-chip class="ma-2 cursor-pointer" color="info"
                        v-for="(v, k) in commentVariants"
                        :key="k" v-text="v"
                        @click="setOfferComment(offer, v)"
                ></v-chip>
            </div>
        </v-expand-transition>

        <v-dialog
            v-model="showOfferDateForm"
            width="600px"
            persistent
        >
            <v-card class="overflow-hidden pa-4">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-date-picker
                            v-model="date"
                            locale="uk"
                            scrollable
                        ></v-date-picker>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-time-picker
                            v-model="time"
                            format="24hr"
                            :allowed-minutes="allowedMinutesStep"
                            full-width
                        ></v-time-picker>
                    </v-col>
                </v-row>
                <v-btn
                    text
                    color="primary"
                    @click="closeOfferDate"
                >Закрити
                </v-btn>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
import {mapActions} from "vuex";
import {cloneDeep as _cloneDeep} from 'lodash';
import reminder from "@/mixin/reminder";

export default {
    name: "Offer",
    mixins: [reminder],
    props: {
        item: {
            type: Object,
            required: true
        },
        callback: {
            type: Function
        }
    },

    data() {
        return {
            offer: this.item,

            commentVariants: ['Не сподобався', 'Хоче дивитися'],
            showCommentReadyVariants: false,
            showOfferCommentForm: false,
            saveOfferId: null,
            editOffer: null,

            showOfferDateForm: false,
            date: this.getTime().date,
            time: this.getTime().time,
        }
    },

    watch: {
        date: {
            handler(newValue, oldValue) {
                if (newValue) this.setOfferDate(newValue)
            },
        },
        time: {
            handler(newValue, oldValue) {
                if (newValue) this.setOfferDate(newValue)
            },
        },
    },

    methods: {
        ...mapActions({
            setOffers: 'OffersModule/setOffers',
        }),

        editOfferComment(offer) {
            this.showOfferCommentForm = offer.id
            this.editOffer = _cloneDeep(offer)
        },

        saveOfferComment(offer) {
            this.showOfferCommentForm = false
            this.showCommentReadyVariants = false

            if (this.editOffer.comment !== offer.comment) {
                this.saveOffer(offer)
            }
        },

        saveOffer(offer) {
            this.saveOfferId = offer.id

            this.axios
                .post(`offers/update`, offer)
                .then(response => {
                    this.saveOfferId = null
                    this.editOffer = null
                })
                .catch(error => {
                    let message = error.message || "Щось пішло не так :/";
                    this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                })
        },

        showCommentVariants(id) {
            if (this.showCommentReadyVariants) {
                this.showCommentReadyVariants = false
            } else this.showCommentReadyVariants = id
        },

        setOfferComment(offer, text) {
            if (offer.comment) offer.comment = offer.comment + ' ' + text
            else offer.comment = text
        },

        showOfferDate(offer) {
            if (offer.show_date) {
                let date = offer.show_date.split(' ')
                this.date = date[0]
                this.time = date[1]
            } else {
                offer.show_date = this.date + ' ' + this.time
            }

            this.editOffer = _cloneDeep(offer)
            this.showOfferDateForm = true
        },

        async closeOfferDate() {
            if (this.offer.show_date !== this.editOffer.show_date) {
                await this.saveOffer(this.offer)
            }

            this.showOfferDateForm = false
            this.editOffer = null
        },

        setOfferDate(dateOrTime) {
            let showDate = this.offer.show_date
            if (showDate) showDate = showDate.split(' ')

            if (dateOrTime.includes(':')) {
                if (showDate) {
                    showDate[1] = dateOrTime
                } else {
                    showDate = [
                        null, dateOrTime
                    ]
                }
            } else {
                if (showDate) {
                    showDate[0] = dateOrTime
                } else {
                    showDate = [
                        dateOrTime, null
                    ]
                }
            }

            this.offer.show_date = showDate.join(' ')
        },

        async archiveOffer(offer) {
            offer.archive = !offer.archive

            await this.saveOffer(offer)

            // this.callback()
        },

        allowedMinutesStep: m => m % 5 === 0,
    }
}
</script>

<style scoped>
.closed {
    opacity: 0.5 !important;
}

.comment-button:hover {
    color: #1976d2;
}

.offer-comment {
    white-space: normal;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
    line-height: 1.9;
}
</style>

<style>
.cursor-pointer {
    cursor: pointer;
}

.border-radius-2 {
    border-radius: 8px;
}

.offer-comment-form {
    font-size: 14px;
    margin-right: 5px !important;
    min-height: 60px;
}

.offer-comment-form,
.offer-comment-form div {
    height: 100%;
}

.offer-comment-form textarea {
    line-height: 1.5;
}

.v-time-picker-title__time .v-picker__title__btn,
.v-time-picker-title__time span {
    height: 55px;
    font-size: 55px;
}
</style>