import {cloneDeep as _cloneDeep} from 'lodash';
import ProfileModel from "./../../models/ProfileModel"
const ProfileModule = {
    namespaced: true,
    state: () => ({
        isProfileLoaded: false,
        profile: _cloneDeep(ProfileModel, true),
    }),
    getters: {
        getIsProfileLoaded (state) {
            return state.isProfileLoaded
        },
        getProfile (state) {
            return state.profile
        },
    },
    mutations: {
        setIsProfileLoaded (state, payload) {
            state.isProfileLoaded = payload
        },
        setProfile (state, payload) {
            state.profile = payload
        },
    },
    actions: {
        setIsProfileLoaded (context, payload) {
            context.commit('setIsProfileLoaded', payload);
        },
        setProfile (context, payload) {
            context.commit('setProfile', payload);
        },
    },

}

export default ProfileModule;
