import Vue from 'vue'
import Vuex from 'vuex'
import mutations from '@/store/mutations'
import getters from '@/store/getters'
import SpinnerModule from '@/store/modules/SpinnerModule'
import UsersModule from '@/store/modules/UsersModule'
import RolesModule from '@/store/modules/RolesModule'
import ClientsModule from '@/store/modules/ClientsModule'
import DashboardModule from '@/store/modules/DashboardModule'
import ProfileModule from '@/store/modules/ProfileModule'
import NavBarModule from '@/store/modules/NavBarModule'
import ErrorLogModule from '@/store/modules/ErrorLogModule'
import SiteLogModule from '@/store/modules/SiteLogModule'
import LandPurposesModule from '@/store/modules/LandPurposesModule'
import RoomTypesModule from '@/store/modules/RoomTypesModule'
import RoomPurposesModule from '@/store/modules/RoomPurposesModule'
import LandOwnershipsModule from '@/store/modules/LandOwnershipsModule'
import OrderModule from "@/store/modules/OrderModule"
import StageModule from "@/store/modules/StageModule"
import IncomeSourcesModule from "@/store/modules/IncomeSourcesModule"
import DynpropsModule from "@/store/modules/DynpropsModule"
import CitiesModule from "@/store/modules/CitiesModule"
import DistrictsModule from "@/store/modules/DistrictsModule"
import FilterModule from "@/store/modules/FilterModule"
import EventsModule from "@/store/modules/EventsModule"
import CardModule from "@/store/modules/CardModule"
import OrderCardModule from "@/store/modules/OrderCardModule"
import OffersModule from "@/store/modules/OffersModule";
import OrderAudiousModule from "@/store/modules/OrderAudiousModule";

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        layout: '',
    },

    modules: {
        SpinnerModule,
        UsersModule,
        RolesModule,
        ClientsModule,
        OrderModule,
        DashboardModule,
        ProfileModule,
        StageModule,
        IncomeSourcesModule,
        NavBarModule,
        ErrorLogModule,
        SiteLogModule,
        LandPurposesModule,
        RoomTypesModule,
        RoomPurposesModule,
        LandOwnershipsModule,
        DynpropsModule,
        CitiesModule,
        DistrictsModule,
        FilterModule,
        EventsModule,
        CardModule,
        OrderCardModule,
        OffersModule,
        OrderAudiousModule,
    },

    mutations,
    getters
});

export default store

