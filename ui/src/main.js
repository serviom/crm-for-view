import Vue from "vue";
import Vuex from "vuex";
import VueRouter from 'vue-router'
import vuetify from './vuetify'
import './assets/styles/app.scss'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
import AudioRecorder from "vue-audio-recorder";

Vue.use(AudioRecorder);

import VueMask from 'v-mask'
Vue.use(VueMask);

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import router from './router'
import store from './store/store'
import moment from 'moment-timezone';


// Load App
import Base from "./Base";
Vue.component("v-base", Base);

//Set Vuex
Vue.use(Vuex);

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);

router.beforeEach((to, from, next) => {
    if (to.meta.title) {
        document.title = `${to.meta.title}`;
    }

    if (to.meta.layout) {
        store.state.layout = to.meta.layout;
    }

    next();
});

// Axios
import axios    from 'axios';
import VueAxios from 'vue-axios';

axios.defaults.baseURL = process.env.VUE_APP_BASEURL;

axios.interceptors.response.use((response) => {
    return response;
}, function (error) {
    switch (error.response.status) {
        case 401: {
            localStorage.removeItem('auth_token_default');
            router.push({name: 'login'}).catch(() => {
            });
            break;
        }
        case 403: {
            router.push({name: 'error-403'}).catch(() => {
            });
            return Promise.reject(error.response);

        }
        case 404: {
            router.push({name: 'error-404'}).catch(() => {
            });
            return Promise.reject(error.response);
        }
        case 422: {
            return Promise.reject(error.response);
        }
        default: {
            let message = ((process.env.VUE_APP_DEBUG === "true") && error.response.data.message) || "Щось погане трапилось :(";
            eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
            return Promise.reject(error.response);
        }
    }
});

Vue.use(VueAxios, axios);

//websanova
import auth                  from '@websanova/vue-auth/dist/v2/vue-auth.esm.js';
import driverAuthBearer      from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js';
import driverHttpAxios       from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js';
import driverRouterVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js';

Vue.use(auth, {
    plugins: {
        http: Vue.axios, // Axios
        // http: Vue.http, // Vue Resource
        router: Vue.router,
    },
    drivers: {
        auth: driverAuthBearer,
        http: driverHttpAxios,
        router: driverRouterVueRouter,
    },
    options: {
        rolesKey: 'roleName',
        tokenDefaultName: 'token',
        tokenStore: ['localStorage'],
        forbiddenRedirect: {path: '/403'},
        notFoundRedirect: {path: '/404'},
        authRedirect: {path: '/login'},
        // registerData: {url: 'auth/register', method: 'POST', redirect: '/dashboard'},
        loginData: {url: 'auth/login', method: 'POST', redirect: "/dashboard", fetchUser: true},
        logoutData: {url: 'auth/logout', method: 'POST', redirect: '/login', makeRequest: true},
        fetchData: {url: 'auth/me', method: 'POST', enabled: true},
        refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: 30}
    }
});

const eventHub = new Vue();

Vue.mixin({
    data: function() {
        return {
            eventHub: eventHub
        };
    }
});

Vue.prototype.$moment = moment;

new Vue({
    render: h => h(Base),
    router,
    store,
    vuetify,
}).$mount('#app')
