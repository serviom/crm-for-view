<template>
    <clients-form-template
        :edit-mode="false"
        :responseErrors="responseErrors"
        title="Новий клієнт"
        @create="create"
    ></clients-form-template>
</template>

<script>
import ClientsFormTemplate from "./ClientsFormTemplate"
import {mapActions, mapGetters} from "vuex";
import ClientModel from "@/models/ClientModel";
import {cloneDeep as _cloneDeep} from 'lodash';

export default {
    components: {
        ClientsFormTemplate,
    },

    data() {
        return {
            responseErrors: {},
        };
    },

    computed: {
        ...mapGetters({
            client: 'ClientsModule/getClient',
            stages: 'StageModule/getList',
        }),
    },

    async created() {
        let client = _cloneDeep(ClientModel)
        await this.setClient(client)
    },

    mounted() {
        if(this.$auth.check(['SuperAdmin'] ,'permissions')) this.getUsers()
    },

    methods: {
        ...mapActions({
            setClient: 'ClientsModule/setClient',
            setAllUsers: 'ClientsModule/setAllUsers',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        getUsers() {
            this.incrementSpinnerCounter();
            this.axios
                .get(`clients/all-users`)
                .then(response => {
                    this.setAllUsers(response.data.data);
                })
                .catch(error => {
                })
                .then(() => {
                    this.decrementSpinnerCounter();
                });
        },

        create (order) {
            this.incrementSpinnerCounter()

            let data = {
                fio:            this.client.fio,
                description:   this.client.description,
                income_source_id: this.client.income_source_id,
                income_source: this.client.income_source,
                user_id:       this.client.user_id,
                social:        this.client.social,
                phoneNumbers:  this.client.phoneNumbers,
                order:         null
            }

            if(! data.user_id && ! this.$auth.check(['SuperAdmin'] ,'permissions')) data.user_id = this.$auth.user().id
            if(order.category) data.order = order

            this.axios
                .post(`clients`, data)
                .then(response => {
                    let message = response.data.message;
                    this.eventHub.$emit("doShowSnackbarEvent" , true, message, 'success', 5000);
                    this.$router.push({ name: 'clients' }).catch(()=>{});
                })
                .catch(error => {
                    if (error.status === 422) {
                        this.responseErrors = error.data.errors;
                        this.eventHub.$emit("doShowClientValidationDialog", error.data);
                    }
                })
                .then(() => {
                    this.decrementSpinnerCounter();
                });
        },
    }
}
</script>

<style scoped>

</style>
