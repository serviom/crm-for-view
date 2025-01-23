import {cloneDeep as _cloneDeep} from 'lodash';
import OrderModel from "@/models/OrderModel"
const OrderModule = {
    namespaced: true,
    state: () => ({
        orders: [],
        order: _cloneDeep(OrderModel),
    }),
    getters: {
        getOrders(state) {
            return state.orders
        },
        getOrder(state) {
            return state.order
        },
    },
    mutations: {
        setOrders(state, payload) {
            state.orders = payload
        },
        setOrder(state, payload) {
            state.order = payload
        },
    },
    actions: {
        setOrders(context, payload) {
            context.commit('setOrders', payload);
        },
        setOrder(context, payload) {
            context.commit('setOrder', payload);
        },
    },
}

export default OrderModule;
