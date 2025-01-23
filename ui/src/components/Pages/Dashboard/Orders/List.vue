<template>
    <v-row>
        <v-col
            v-for="(item, i) in orders"
            :key="i"
            cols="12" lg="6"
        >
            <order
                :order="item"
                :showClientData="false"
            />
        </v-col>
    </v-row>
</template>

<script>
import Order from "@/components/Pages/Dashboard/Orders/Order";
import {mapGetters} from "vuex";

export default {
    name: "OrdersList",
    components: {Order},
    computed: {
        ...mapGetters({
            orders: 'OrderModule/getOrders',
        }),
    },
}
</script>

<style scoped>

</style>