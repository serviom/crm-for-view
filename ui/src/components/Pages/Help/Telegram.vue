<template>
    <div class="mt-5">
        <v-row>
            <v-col>
                <v-btn
                    color="primary"
                    @click="setWebhook"
                >
                    Set Webhook
                </v-btn>
            </v-col>
        </v-row>

        <v-row v-if="setData">
            <v-col cols="12" md="9">
                <v-row>
                    <v-col cols="12">
                        <v-alert
                            :type="setData.success"
                            border="left"
                        >{{ setData.result }}</v-alert>
                    </v-col>
                    <v-col cols="12">
                        <pre v-if="setData.data">{{ setData.data }}</pre>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

    </div>
</template>

<script>
import {mapActions} from "vuex";
import ProfileModel from "@/models/ProfileModel";

export default {
    name: "Telegram",
    data() {
        return {
            setData: null,
        };
    },
    methods: {
        ...mapActions({
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        setWebhook() {
            this.axios
                .post(`telegram/set-webhook`, {})
                .then(response => {
                    this.setData = response.data.data
                    if(this.setData) {
                        if(this.setData.ok) {
                            if(this.setData.result) {
                                this.setData = this.setData.result

                                if(this.setData.last_error_date) {
                                    let unix_timestamp = this.setData.last_error_date
                                    let date = new Date(unix_timestamp * 1000)
                                    this.setData.last_error_date = date.toLocaleDateString() + ' ' + date.toLocaleTimeString()
                                }

                                this.setData = {
                                    result: 'Підключення налаштоване корректно',
                                    success: 'success',
                                    data: this.setData
                                }
                            }
                        } else {
                            this.setData = {
                                result: 'TELEGRAM_BOT_TOKEN квазаний не корректно',
                                success: 'warning',
                                data: this.setData
                            }
                        }
                    } else {
                        this.setData = {
                            result: 'Невідома помилка',
                            success: 'error',
                            data: this.setData
                        }
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
    }
}
</script>

<style scoped>

</style>