import {cloneDeep as _cloneDeep} from 'lodash';
import UserModel from "./../../models/UserModel"
const UsersModule = {
    namespaced: true,
    state: () => ({
        allRoles: [],
        users: [],
        user: _cloneDeep(UserModel, true),
    }),
    getters: {
        getAllRoles (state) {
            return state.allRoles
        },
        getUsers (state) {
            return state.users
        },
        getUser (state) {
            return state.user
        },
    },
    mutations: {
        setAllRoles(state, payload) {
            state.allRoles = payload
        },
        setUsers (state, payload) {
            state.users = payload
        },
        setUser (state, payload) {
            state.user = payload
        },
    },
    actions: {
        setAllRoles (context, payload) {
            context.commit('setAllRoles', payload);
        },
        setUsers (context, payload) {
            context.commit('setUsers', payload);
        },
        setUser (context, payload) {
            context.commit('setUser', payload);
        },
    },

}

export default UsersModule;
