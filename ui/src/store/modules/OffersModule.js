import {cloneDeep as _cloneDeep} from 'lodash';
import OfferModel from "@/models/OfferModel"
const OffersModule = {
    namespaced: true,
    state: () => ({
        offers: [],
        offer: _cloneDeep(OfferModel),
    }),
    getters: {
        getOffers(state) {
            return state.offers
        },
        getOffer(state) {
            return state.offer
        },
    },
    mutations: {
        setOffers(state, payload) {
            state.offers = payload
        },
        setOffer(state, payload) {
            state.offer = payload
        },
    },
    actions: {
        setOffers(context, payload) {
            context.commit('setOffers', payload);
        },
        setOffer(context, payload) {
            context.commit('setOffer', payload);
        },
    },
}

export default OffersModule;
