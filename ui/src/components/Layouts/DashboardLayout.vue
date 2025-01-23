<template>
    <v-app>
        <v-overlay
            :z-index="100"
            v-if="isShowSpinner"
            :value="true"
            :absolute="true"
            :opacity="0.15"
            class="d-block w-100 align-items-start"
        >
            <div class="position-fixed w-100">
                <crm-spinner-with-counter></crm-spinner-with-counter>
            </div>
        </v-overlay>
        <v-navigation-drawer
            class="left-menu"
            v-model="drawer"
            :mini-variant.sync="mini"
            app
        >
            <!-- -->
            <v-list
                nav
                dense
                class="nav-menu-logo py-0 d-flex align-center"
            >
                <v-list-item
                    link
                >
                    <v-list-item-icon>
                        <v-icon size="24">mdi-speedometer</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title><b class="h4">Швидкість-Crm</b></v-list-item-title>
                </v-list-item>
            </v-list>

            <v-list
                nav
                dense
            >
                <v-alert
                    v-if="dev"
                    dense dark type="warning" icon="mdi-alert-outline"
                >Тестова версія</v-alert>

                <router-link :to="{ name: 'dashboard'}">
                    <v-tooltip
                        :disabled="!mini"
                        right
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                v-bind="attrs"
                                v-on="on"
                                link
                                class="menu-item"
                            >
                                <v-list-item-icon>
                                    <v-icon>mdi-home</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Головна</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Головна</span>
                    </v-tooltip>
                </router-link>

                <router-link
                    v-if="$auth.check(['SuperAdmin', 'clients.viewAny', 'clients.viewMyOnly'] ,'permissions')"
                    :to="{ name: 'clients'}"
                >
                    <v-tooltip
                        :disabled="!mini"
                        right
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                v-bind="attrs"
                                v-on="on"
                                link
                                class="menu-item"
                            >
                                <v-list-item-icon>
                                    <v-icon>mdi-briefcase-account</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Клієнти</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Клієнти</span>
                    </v-tooltip>
                </router-link>

                <router-link
                    v-if="$auth.check(['SuperAdmin', 'users.viewAny', 'users.viewMyOnly'] ,'permissions')"
                    :to="{ name: 'users'}"
                >
                    <v-tooltip
                        :disabled="!mini"
                        right
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                v-bind="attrs"
                                v-on="on"
                                link
                                class="menu-item"
                            >
                                <v-list-item-icon>
                                    <v-icon>mdi-account-multiple</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Користувачі</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Користувачі</span>
                    </v-tooltip>
                </router-link>

                <router-link
                    :to="{ name: 'objects'}"
                >
                    <v-tooltip
                        :disabled="!mini"
                        right
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-list-item
                                v-bind="attrs"
                                v-on="on"
                                link
                                class="menu-item"
                            >
                                <v-list-item-icon>
                                    <v-icon>mdi-home-city</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>Об'єкти</v-list-item-title>
                            </v-list-item>
                        </template>
                        <span>Об'єкти</span>
                    </v-tooltip>
                </router-link>

                <v-tooltip
                    :disabled="!mini"
                    right
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-list-group
                            v-bind="attrs"
                            v-on="on"
                            v-if="$auth.check([
                                'SuperAdmin', 'statistics.viewAny', 'statistics.clients',
                                'statistics.orders', 'statistics.offers', 'statistics.prices'
                            ] ,'permissions')"
                            :value="isActive([
                                'statistics.clients',
                                'statistics.orders',
                                'statistics.offers',
                                'statistics.prices',
                                ])"
                            prepend-icon="mdi-chart-areaspline"
                        >
                            <template v-slot:activator>
                                <v-list-item-title>Статистика</v-list-item-title>
                            </template>

                            <router-link
                                v-if="$auth.check(['SuperAdmin', 'statistics.viewAny', 'statistics.clients'] ,'permissions')"
                                :to="{ name: 'statistics.clients'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-chart-bar</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Клієнти</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Клієнти</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="$auth.check(['SuperAdmin', 'statistics.viewAny', 'statistics.orders'] ,'permissions')"
                                :to="{ name: 'statistics.orders'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-chart-bar</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Угоди</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Угоди</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="$auth.check(['SuperAdmin', 'statistics.viewAny', 'statistics.offers'] ,'permissions')"
                                :to="{ name: 'statistics.offers'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-chart-bar</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Покази</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Покази</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="$auth.check(['SuperAdmin', 'statistics.viewAny', 'statistics.prices'] ,'permissions')"
                                :to="{ name: 'statistics.prices'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-chart-bar</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Ціни</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Ціни</span>
                                </v-tooltip>
                            </router-link>

                        </v-list-group>
                    </template>
                    <span>Статистика</span>
                </v-tooltip>

                <v-tooltip
                    :disabled="!mini"
                    right
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-list-group
                            v-bind="attrs"
                            v-on="on"
                            v-if="$auth.check(['SuperAdmin'].concat(getAllForDirectories()) ,'permissions')"
                            :value="isActive([
                                'dictionaries.land_purposes',
                                'dictionaries.land_purposes.create',
                                'dictionaries.land_purposes.update',
                                'dictionaries.room_types',
                                'dictionaries.room_types.create',
                                'dictionaries.room_types.update',
                                'dictionaries.room_purposes',
                                'dictionaries.room_purposes.create',
                                'dictionaries.room_purposes.update',
                                'dictionaries.land_ownerships',
                                'dictionaries.land_ownerships.create',
                                'dictionaries.land_ownerships.update',
                                ])"
                            prepend-icon="mdi-book-multiple"
                        >
                            <template v-slot:activator>
                                <v-list-item-title>Довідники</v-list-item-title>
                            </template>
                            <router-link
                                v-if="

                                (1===0) &&

                                $auth.check(['SuperAdmin', 'room_type.viewAny'] ,'permissions')"
                                :to="{ name: 'dictionaries.room_types'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Тип приміщення</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Тип приміщення</span>
                                </v-tooltip>
                            </router-link>
                            <router-link
                                v-if="

                                (1===0) &&

                                $auth.check(['SuperAdmin', 'land_ownership.viewAny'] ,'permissions')"
                                :to="{ name: 'dictionaries.land_ownerships'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Право власності на землю</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Право власності на землю</span>
                                </v-tooltip>
                            </router-link>
                            <router-link
                                v-if="

                                (1===0) &&

                                $auth.check(['SuperAdmin', 'land_purpose.viewAny'] ,'permissions')"
                                :to="{ name: 'dictionaries.land_purposes'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Ділянки. Цільове призначення</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Ділянки. Цільове призначення</span>
                                </v-tooltip>
                            </router-link>
                            <router-link
                                v-if="

                                (1===0) &&

                                $auth.check(['SuperAdmin', 'room_purpose.viewAny'] ,'permissions')"
                                :to="{ name: 'dictionaries.room_purposes'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Приміщення. Цільове призначення</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Приміщення. Цільове призначення</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="$auth.check(['SuperAdmin'].concat(getAllForDirectoryStageAgreement()) ,'permissions')"
                                :to="{ name: 'dictionaries.stages'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Етапи угоди</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Етапи угоди</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="$auth.check(['SuperAdmin'].concat(getAllForDirectoryIncomeSources()),'permissions')"
                                :to="{ name: 'dictionaries.income_sources'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Джерела надходження</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Джерела надходження</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="

                                (1===0) &&

                                $auth.check(['SuperAdmin'] ,'permissions')"
                                :to="{ name: 'dictionaries.cities'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Міста</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Міста</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="$auth.check(['SuperAdmin'].concat(getAllForDirectoryDistricts()),'permissions')"
                                :to="{ name: 'dictionaries.districts'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-book</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Райони</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                </v-tooltip>
                            </router-link>

                        </v-list-group>
                    </template>
                    <span>Довідники</span>
                </v-tooltip>

                <v-tooltip
                    :disabled="!mini"
                    right
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-list-group
                            v-bind="attrs"
                            v-on="on"
                            v-if="$auth.check(['SuperAdmin', 'roles.viewAny'] ,'permissions')"
                            :value="isActive([
                                'roles',
                                'roles.create',
                                'roles.update',
                                ])"
                            prepend-icon="mdi-crown"
                        >
                            <template v-slot:activator>
                                <v-list-item-title>SuperAdmin</v-list-item-title>
                            </template>

                            <router-link
                                v-if="$auth.check(['SuperAdmin', 'roles.viewAny'] ,'permissions')"
                                :to="{ name: 'roles'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-drama-masks</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Ролі</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Ролі</span>
                                </v-tooltip>
                            </router-link>

                            <router-link
                                v-if="$auth.check(['SuperAdmin'] ,'permissions')"
                                :to="{ name: 'telegram'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-microsoft</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Telegram</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Telegram</span>
                                </v-tooltip>
                            </router-link>

                        </v-list-group>
                    </template>
                    <span>SuperAdmin</span>
                </v-tooltip>

                <v-tooltip
                    :disabled="!mini"
                    right
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-list-group
                            v-bind="attrs"
                            v-on="on"
                            v-if="$auth.check(['SuperAdmin', 'logs.viewAny', 'actions.viewAny'] ,'permissions')"
                            :value="isActive([
                                'system.logs',
                                'system.logs.view',
                                'site.logs'
                                ])"
                            prepend-icon="mdi-cog"
                        >
                            <template v-slot:activator>
                                <v-list-item-title>Система</v-list-item-title>
                            </template>
                            <router-link
                                v-if="$auth.check(['SuperAdmin', 'logs.viewAny'] ,'permissions')"
                                :to="{ name: 'system.logs'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-alert</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Лог помилок</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                    <span>Лог помилок</span>
                                </v-tooltip>
                            </router-link>
                            <router-link
                                v-if="$auth.check(['SuperAdmin', 'actions.viewAny'] ,'permissions')"
                                :to="{ name: 'site.logs'}"
                            >
                                <v-tooltip
                                    :disabled="!mini"
                                    right
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-list-item
                                            v-bind="attrs"
                                            v-on="on"
                                            link
                                            class="menu-item"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>mdi-format-list-bulleted</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title>Лог сайту</v-list-item-title>
                                        </v-list-item>
                                    </template>
                                  <span>Лог сайту</span>
                                </v-tooltip>
                            </router-link>
                        </v-list-group>
                    </template>
                    <span>Система</span>
                </v-tooltip>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app>
            <div class="d-flex justify-space-between w-100 h-100">
                <div class="d-flex align-center">
                    <v-app-bar-nav-icon
                        @click.stop="mini = !mini"
                        class="d-none d-lg-flex"
                    ></v-app-bar-nav-icon>
                    <v-app-bar-nav-icon
                        @click.stop="drawer = !drawer"
                        class="d-flex d-lg-none"
                    ></v-app-bar-nav-icon>
                    <v-toolbar-title>{{ title }}</v-toolbar-title>
                </div>
                <div class="d-flex align-center">
                    <reminder />

                    <v-menu
                        v-if="getIsShowUserWidget"
                        offset-y
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <div
                                v-on="on"
                                v-bind="attrs"
                                class="profile-widget d-flex align-items-center ml-6 mr-3"
                            >
                                <div class="d-none d-sm-flex flex-column align-items-end">
                                    <div class="profile-widget-info">{{ setIsProfileLoaded ? getProfile.name : loadingMessage }}</div>
                                    <div class="caption">{{ setIsProfileLoaded ? getProfile.roleName : loadingMessage }}</div>
                                </div>
                                <v-img
                                    v-if="setIsProfileLoaded && getProfile.avatar"
                                    class="avatar-image rounded-circle m-sm-3"
                                    aspect-ratio="1"
                                    width="45"
                                    :src="getProfile.avatar"
                                ></v-img>
                                <v-icon
                                    v-else
                                    class="no-avatar ml-3"
                                >mdi-account</v-icon>
                            </div>
                        </template>

                        <v-list>
                            <v-list-item
                                class="d-block d-sm-none"
                            >
                                <v-list-item-title>
                                    <div>
                                        <div>{{ setIsProfileLoaded ? getProfile.name : loadingMessage }}</div>
                                        <div class="caption">{{ setIsProfileLoaded ? getProfile.roleName : loadingMessage }}</div>
                                    </div>
                                </v-list-item-title>
                            </v-list-item>
                            <router-link
                                class="text-dark w-100"
                                :to="{ name: 'profile'}"
                            >
                                <v-list-item
                                    link
                                    class="menu-item"
                                >
                                    <v-list-item-title>Профіль</v-list-item-title>
                                </v-list-item>
                            </router-link>
                            <router-link
                                class="text-dark w-100"
                                :to="{ name: 'profile', query: {tab: 'objects'}}"
                            >
                                <v-list-item
                                    link
                                    class="menu-item none-active"
                                >
                                    <v-list-item-title>
                                        Об'єкти
                                    </v-list-item-title>
                                </v-list-item>
                            </router-link>
                            <v-list-item
                                link
                                class="menu-item"
                            >
                                <v-list-item-title @click.prevent="$auth.logout()" class="text-dark" >Вихід</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
            </div>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main relative>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

                <!-- If using vue-router -->
                <router-view></router-view>

                <crm-flash-message></crm-flash-message>

            </v-container>

        </v-main>

        <v-footer class="footer" app>Розробка - iyExpert © 2023</v-footer>

        <v-bottom-sheet
            inset fullscreen scrollable persistent
            transition="slide-x-transition"
            elevation="0"
            v-model="showCard"
        >
            <order-card v-model="orderCard" />
        </v-bottom-sheet>
    </v-app>
</template>

<script>
import CrmFlashMessage from "@/components/Common/CrmFlashMessage"
import CrmSpinnerWithCounter from "@/components/Common/CrmSpinnerWithCounter"
import {mapActions, mapGetters} from "vuex";
import Reminder from "@/components/Common/Header/Reminder";
import OrderCard from "@/components/Pages/Dashboard/Orders/Card";
import permissions from "@/mixin/permissions";

export default {
    components: {
        Reminder,
        CrmFlashMessage,
        CrmSpinnerWithCounter,
        OrderCard,
    },
    mixins: [permissions],
    data() {
        return {
            title: "",
            loadingMessage: "завантаження",
            drawer: true,
            mini: false,
            currentRouteName: null,
            dev: false,
        };
    },
    computed: {
        ...mapGetters({
            isShowSpinner: 'SpinnerModule/isShowSpinner',
            getProfile: 'ProfileModule/getProfile',
            getIsProfileLoaded: 'ProfileModule/getIsProfileLoaded',
            getIsShowUserWidget: 'NavBarModule/getIsShowUserWidget',
            showCard: 'CardModule/getShow',
            orderCard: 'OrderCardModule/getShow',
        }),
    },
    watch: {
        $route: function () {
            this.title = this.$route.meta.title;
            this.currentRouteName = this.$route.name;
        }
    },

    created() {
        this.init();
    },

    mounted() {
        this.dev = process.env.VUE_APP_ENV !== "production"
    },

    methods: {
        ...mapActions({
            setProfile: 'ProfileModule/setProfile',
            setIsProfileLoaded: 'ProfileModule/setIsProfileLoaded',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        isActive(urls) {
            return urls ? urls.includes(this.currentRouteName) : false;
        },

        init() {
            this.getProfileData()
        },

        getProfileData() {
            this.incrementSpinnerCounter();
            this.axios
                .get(`profile`,)
                .then(response => {
                    this.setProfile(response.data.data);
                    this.setIsProfileLoaded(true);
                })
                .catch(error => {})
                .finally(() => {
                    this.decrementSpinnerCounter();
                });
        },
    }
}
</script>

<style scoped lang="scss">
.profile-widget {

    .profile-widget-info {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
}
.no-avatar {
    width: 45px;
    height: 45px;
    border: 1px solid grey;
    border-radius: 100%;
}
.avatar-image {
    width: 45px;
    height: 45px;
    border: 1px solid grey;
    border-radius: 100%;
}
.router-link-active {
    .menu-item:not(.none-active) {
        background-color: #1976d2!important;
    }

    .theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
        color: white!important;
    }

    .theme--light.v-icon {
        color: white!important;
    }

    .menu-item.none-active.theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled){
        color: inherit!important;
    }
}
.nav-menu-logo {
    height: 64px;
    border-bottom: 1px solid;
    border-color: rgba(0,0,0,.12);
    background-color: #1976d2 !important;

    .theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
        color: white!important;
    }

    .theme--light.v-icon {
        color: white!important;
    }
}
.container--fluid {
    max-width: 100%;
}
.footer {
    position: relative;
    z-index: 11;
}
.left-menu {
    max-height: 100% !important;
}
</style>
<style>
@media(max-width: 600px) {
    .v-toolbar__content {
        padding-left: 10px;
        padding-right: 10px;
    }
}
</style>
