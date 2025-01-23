<template>
    <v-container fluid>
        <v-row>
            <v-col
                cols="12"
                sm="12"
            >
                <v-tabs
                    v-model="tab"
                    background-color="transparent"
                    :mobile-breakpoint="null"
                >
                    <v-tab
                    >
                        Мій профіль
                    </v-tab>
                    <v-tab
                    >
                        Об'єкти
                    </v-tab>
                    <v-tab
                        v-show="$auth.check(['SuperAdmin', 'clients.viewAny', 'clients.viewMyOnly'] ,'permissions')"
                    >
                        Клієнти
                    </v-tab>
					<v-tab
						v-show="$auth.check(['SeniorAgent'] ,'permissions')"
					>
						Мої агенти
					</v-tab>
                    <v-tab
                    >
                        Лог дій
                    </v-tab>
                </v-tabs>

                <v-tabs-items v-model="tab">
                    <v-tab-item
                    >
                        <v-card
                            flat
                        >
                            <my-profile></my-profile>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item
                    >
                        <v-card
                            flat
                        >
                            <my-objects></my-objects>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item
                    >
                        <v-card
                            v-show="$auth.check(['SuperAdmin', 'clients.viewAny', 'clients.viewMyOnly'] ,'permissions')"
                        >
                            <my-clients></my-clients>
                        </v-card>
                    </v-tab-item>
					<v-tab-item
					>
						<v-card
							v-show="$auth.check(['SeniorAgent'] ,'permissions')"
						>
							<my-agents></my-agents>
						</v-card>
					</v-tab-item>
                    <v-tab-item
                    >
                        <v-card
                            flat
                        >
                            <my-actions></my-actions>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>

            </v-col>
        </v-row>
    </v-container>
</template>

<script>

import MyProfile from "@/components/Pages/Dashboard/Profile/MyProfile";
import MyObjects from "@/components/Pages/Dashboard/Profile/MyObjects";
import MyClients from "@/components/Pages/Dashboard/Profile/MyClients";
import MyAgents from "@/components/Pages/Dashboard/Profile/MyAgents";
import MyActions from "@/components/Pages/Dashboard/Profile/MyActions";
import {filter as _filter} from "lodash";

export default {
    components: {
		MyAgents,
        MyProfile,
        MyObjects,
        MyClients,
        MyActions
    },
    data() {
        return {
            tab: null,
            tabsIndexes: {
                profile: 0,
                objects: 1,
                clients: 2,
				agents: 3,
                actions: 4,
            },
        };
    },
    watch: {
        $route: function () {
            if (!this.$route.query.tab) {
                this.tab = 0;
            } else {
                this.tab = this.tabsIndexes[this.$route.query.tab];
            }
        },
        tab: function () {
            this.changedTab();
        }
    },
    mounted() {
        if (this.$route.query.tab) {
            this.tab = this.tabsIndexes[this.$route.query.tab];
        }
    },
    methods: {
        changedTab() {
            let query = Object.assign({}, this.$route.query);
            let tab = _filter(Object.keys(this.tabsIndexes), (key) => {
                return this.tabsIndexes[key] === this.tab;
            })[0];
            if (query.tab !== tab) {
                query.tab = tab;
                this.$router.replace({query}).catch(() => {
                });
            }
        }
    }
}
</script>
