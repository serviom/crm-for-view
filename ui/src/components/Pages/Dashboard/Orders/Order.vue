<template>
    <v-card
        outlined
        :color="item.color.color ? item.color.color : 'white'"
        :dark="item.color.white_text"
        elevation="3"
        :class="{'order-item':true, 'closed':item.closed_at}"
    >
        <div class="d-flex flex-no-wrap justify-space-between">
            <v-badge
                right
                bordered
                light
                overlap
                :color="item.closed_at ? '#ccc' : 'success'"
            ></v-badge>

            <div class="w-100" v-show="!item.edit">

                <div
                    class="pa-4 pb-2 order-title-container cursor-pointer"
                    @click="openCard(item)"
                >
                    <div class="d-flex">
                        <div class="d-flex w-100">
                            <div class="d-flex flex-column w-100">
                                <div class="d-flex justify-content-between order-title">
                                    <span>
                                        <v-icon
                                            :dark="item.color.white_text"
                                            :size="item.client ? '25' : '35'"
                                            :height="item.client ? '25px' : '35px'"
                                            class="mr-2"
                                        >{{ catIcon(item.category) }}</v-icon>{{ item.category }}{{ item.rooms.length ?  ', ' + item.rooms + 'к' : '' }}
                                    </span>
                                    <span>
                                        {{ item.adv_type }}
                                    </span>
                                </div>
                                <div v-if="showClientData || (item.price && !item.type && !item.repair)"
                                    class="d-flex justify-content-between mt-3">
                                    <div
                                        v-if="showClientData"
                                        class="d-flex flex-column justify-content-between order-client fs-12"
                                    >
                                        <span
                                            v-if="item.client"
                                        >{{ item.client.fio }}</span>

                                        <a v-if="item.client && item.client.phone_numbers.length"
                                           class="order-phone"
                                           :href="'tel:' + applyPhoneMask(item.client.phone_numbers[0].phoneNumber)"
                                        >{{ applyPhoneMask(item.client.phone_numbers[0].phoneNumber) }}</a>
                                    </div>

                                    <div
                                        v-if="item.price && !item.type && !item.repair"
                                        class="d-flex h-100 align-items-end"
                                    >
                                        <v-chip x-small link class="px-3 py-3"
                                        >{{ priceFormat(item.price) }}</v-chip>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 pb-3 d-flex w-100 justify-content-between order-body-container"
                     v-if="(item.type || item.repair) && item.category !== 'Ділянка'"
                >
                    <div>
                        <v-chip v-if="item.type && item.category !== 'Ділянка' && item.type !== 'Всі'"
                                x-small link class="mr-2 px-3 py-3"
                        >{{ item.type }}
                        </v-chip>
                        <v-chip v-if="item.repair && item.category !== 'Ділянка'"
                                x-small link class="mr-2 px-3 py-3"
                        >{{ item.repair }}
                        </v-chip>
                    </div>
                    <v-chip v-if="item.price"
                            x-small link class="px-3 py-3"
                    >{{ priceFormat(item.price) }}
                    </v-chip>
                </div>
            </div>
        </div>
    </v-card>
</template>

<script>
import applyPhoneMaskMixin from "@/mixin/applyPhoneMaskMixin";
import priceFormatter from "@/mixin/priceFormatter";
import categoryIcons from "@/mixin/categoryIcons";
import {mapActions} from "vuex";

export default {
    name: "Order",
    mixins: [applyPhoneMaskMixin, priceFormatter, categoryIcons],
    props: {
        order: {
            type: Object,
            required: true
        },
        showClientData: {
            type: Boolean,
            default: true
        },
        callback: {
            type: Function,
            default: ()=>{}
        },
    },
    data() {
        return {
            item: this.order,
        };
    },
    methods: {
        ...mapActions({
			setCard: 'CardModule/setShow',
            setOrderCard: 'OrderCardModule/setShow',
            setOrder: 'OrderModule/setOrder',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        openCard(item) {
            this.setOrder(item)
			this.setCard(true)
            this.setOrderCard(true)
        },
    }
}
</script>

<style scoped>
.closed {
    opacity: 0.7;
}
</style>
<style>
.fs-12 {
    font-size: 12px;
}
</style>