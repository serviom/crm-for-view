<template>
    <div class="w-100 mx-0">
        <v-list three-line class="comments-container pt-0">
            <template v-for="(item, i) in (data.length ? items : list)">
                <v-list-item
                    v-if="item.items"
                    :key="i"
                    :class="'d-flex align-items-center pa-0 comment-item' + (openItem === i ? ' open' : '')"
                    style="min-height: inherit;"
                >
                    <div class="w-100">
                        <v-card-actions class="group-section" @click="toggleItem(i)">
                            <div class="d-flex justify-content-between order-title">
                                <span>
                                    <v-icon
                                        :dark="openItem === i"
                                        size="25"
                                        height="25px"
                                        class="mr-3"
                                    >{{ catIcon(item.category) }}</v-icon>{{ item.title }}
                                </span>
                                <span>
                                    {{ item.adv_type }}
                                </span>
                            </div>

                            <v-spacer></v-spacer>

                            <v-btn icon :dark="openItem === i">
                                <v-icon>{{ openItem === i ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-expand-transition>
                            <div v-show="openItem === i">
                                <v-list three-line class="comments-container py-0">
                                    <template v-for="(group, ii) in item.items">
                                        <comment-item
                                            :key="ii"
                                            :multiple="true"
                                            :item="group"
                                        />
                                    </template>
                                </v-list>
                            </div>
                        </v-expand-transition>
                    </div>
                </v-list-item>

                <comment-item
                    v-else
                    :key="i"
                    :item="item"
                />
            </template>
        </v-list>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import dateFormatter from "@/mixin/dateFormatter";
import CommentItem from "@/components/Pages/Dashboard/Comments/CommentItem";
import categoryIcons from "@/mixin/categoryIcons";

export default {
    name: "CommentsList",
    mixins: [dateFormatter, categoryIcons],
    components: {CommentItem},
    props: {
        entity: {
            type: String,
            required: true
        },
        data: {
            type: Array,
            default: ()=>{return []},
        },
        id: {
            type: Number,
            required: true
        },
        reload: {
            type: Number,
            required: true
        },
    },
    mounted() {
        this.list = []
        this.getComments()
    },
    watch: {
        id() {
            if(this.id) {
                this.list = []
                this.items = []
                this.getComments()
            }
        },
        reload() {
            this.getComments()
        },
    },
    data() {
        return {
            list: [],
            items: [],
            openItem: false,
        }
    },
    methods: {
        ...mapActions({
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),
        getComments(){
            this.incrementSpinnerCounter()

            this.axios
                .post(`${this.entity}/comments`, {id:this.id})
                .then(response => {
                    this.items = []
                    this.list = response.data.list
                    this.list.filter(item => item.order_id===0).forEach(item => this.items.push(item))
                    if(this.data.length) {
                        this.data.forEach(order => {
                            let items = this.list.filter(item => item.order_id===order.id)
                            if(items.length) this.items.push({
                                date: items[0].date,
                                category: order.category,
                                title: order.category + (order.rooms.length ?  ', ' + order.rooms + 'к' : '') + (', ' + order.adv_type),
                                items
                            })
                        })
                    }
                    let dateParse = this.dateParse
                    this.items.sort(function(a, b) {
                        return dateParse(b.date).getTime() - dateParse(a.date).getTime()
                    })
                })
                .catch(error => {
                    let message = error.message || "Щось пішло не так :/";
                    this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                })
                .finally(() => {
                    this.decrementSpinnerCounter()
                });
        },

        toggleItem(id) {
            this.openItem = this.openItem === id ? false : id
        },
    }
}
</script>

<style>
.comments-container {
    background-color: transparent !important;
}
.group-section {
    cursor: pointer;
    margin-left: -4px;
    padding-left: 12px;
}
.comment-item:not(:last-child) {
    border-bottom: 1px solid rgba(0, 0, 0, .12);
}
.comments-container .comment-item {
    background-color: rgba(0,0,0,0.01);
}
.comments-container .comment-item:nth-child(even) {
    background-color: rgba(0,0,0,0.03);
}
.comment-item {
    border-left: 4px dashed transparent;
}
.comment-item.open {
    border-left-color: #1976d2;
}
.comment-item.open .group-section {
    background-color: #1976d2;
    color: #ffffff;
}
</style>