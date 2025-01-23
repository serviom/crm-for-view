<template>
    <div class="pa-5 pl-0 pr-10" v-show="show">
        <v-timeline
            dense clipped
        >
            <v-timeline-item
                v-for="(item, i) in list"
                :key="i"
                class="mb-0 white--text"
                left fill-dot
            >
                <template v-slot:icon>
                    <span>{{ list.length - i }}</span>
                </template>
                <v-card elevation="2">
                    <v-card-text class="pa-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <v-chip label color="primary" v-if="item.log.prev || item.log.new">
                                    {{ item.log.prev ? stagesList[item.log.prev] : '' }}
                                    <v-icon v-if="item.log.prev || item.log.new" class="px-2">mdi-ray-start-arrow</v-icon>
                                    {{ item.log.new ? stagesList[item.log.new] : '' }}
                                </v-chip>
                                <span class="ml-5 font-weight-bold">{{ item.title }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="ml-3 mr-5">{{ dateFormat(item.date) }}</span>
                                <router-link
                                    v-if="item.user_id && item.user_name" :to="{ name: 'users.update', params: { id: item.user_id } }"
                                >
                                    <v-chip class="cursor-pointer"
                                        dark color="green lighten-1"
                                    >{{ item.user_name }}</v-chip>
                                </router-link>
                                <span v-else>-</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                        </div>
                    </v-card-text>
                </v-card>
            </v-timeline-item>
        </v-timeline>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import dateFormatter from "@/mixin/dateFormatter";

export default {
    name: "ClientLogList",
    mixins: [dateFormatter],
    props: {
        show: {
            type: Boolean,
            default: false
        },
        list: {
            type: Array
        },
    },
    mounted() {
        this.getHandbooks()
    },
    computed: {
        ...mapGetters({
            stagesList: 'StageModule/getArray',
        }),
    },
    methods: {
        ...mapActions({
            setStages: 'StageModule/setList',
        }),

        async getHandbooks() {
            await this.axios
                .get(`handbook/stages`, {})
                .then(response => {
                    this.setStages(response.data.data)
                })
                .catch(error => {})
                .then(() => {});
        },
    },
}
</script>

<style scoped>

</style>