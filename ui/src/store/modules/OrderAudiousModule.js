import {cloneDeep as _cloneDeep} from 'lodash';
import OrderAudioModel from "@/models/OrderAudioModel"
const OrderAudiousModule = {
    namespaced: true,
    state: () => ({
        items: [],
        item: _cloneDeep(OrderAudioModel),
    }),
    getters: {
        getAudious(state) {
            return state.items
        },
        getAudio(state) {
            return state.item
        },
    },
    mutations: {
        setAudious(state, payload) {
            state.items = payload
        },
        setAudio(state, payload) {
            state.item = payload
        },
    },
    actions: {
        setAudious(context, payload) {
            context.commit('setAudious', payload);
        },
        setAudio(context, payload) {
            context.commit('setAudio', payload);
        },
    },
}

export default OrderAudiousModule;
