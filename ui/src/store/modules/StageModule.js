import {cloneDeep as _cloneDeep} from 'lodash';
import StageModel from "@/models/StageModel"
const StageModule = {
    namespaced: true,
    state: () => ({
        stage: _cloneDeep(StageModel),
        list: [],
        array: [],
    }),
    getters: {
        getStage (state) {
            return state.stage
        },
        getList (state) {
            return state.list
        },
        getArray(state) {
            return state.array
        },
    },
    mutations: {
        setStage (state, payload) {
            state.stage = payload
        },
        setList (state, payload) {
            state.list = payload

            let array = []
            payload.forEach(item => { array[item.id] = item.title })
            state.array = array
        },
    },
    actions: {
        setStage (context, payload) {
            context.commit('setStage', payload);
        },
        setList (context, payload) {
            context.commit('setList', payload);
        },
    },
}

export default StageModule;
