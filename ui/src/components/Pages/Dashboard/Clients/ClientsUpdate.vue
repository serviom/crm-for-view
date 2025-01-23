<template>
    <clients-form-template
        :edit-mode="true"
        :responseErrors="responseErrors"
        title="Редагувати клієнта"
        @edit="edit"
    ></clients-form-template>
</template>

<script>
import ClientsFormTemplate from "./ClientsFormTemplate"
import {mapActions, mapGetters} from "vuex";
import ClientModel from "../../../../models/ClientModel";
import {cloneDeep as _cloneDeep} from 'lodash';

export default {
    components: {
        ClientsFormTemplate,
    },

    data() {
        return {
            clientId: null,
            responseErrors: {},
        };
    },

    computed: {
        ...mapGetters({
            client: 'ClientsModule/getClient',
        }),
    },

    async created() {
        await this.setClient(_cloneDeep(ClientModel));
    },

    mounted() {
        this.clientId = this.$route.params.id
        this.getClient()
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

        getClient() {
            this.incrementSpinnerCounter();
            this.axios
                .get(`clients/${this.clientId}`)
                .then(response => {
                    this.setClient(response.data.data)

                    if(!this.client.phoneNumbers.length) this.client.phoneNumbers = [{phoneNumber: ''}]
                })
                .catch(error => {
                })
                .then(() => {
                    this.decrementSpinnerCounter();
                });
        },

        edit () {

            this.incrementSpinnerCounter();

            this.axios
                .put(`clients/${this.clientId}`, {
                    fio:           this.client.fio,
                    description:  this.client.description,
                    income_source_id: this.client.income_source_id,
                    income_source: this.client.income_source,
                    user_id:      this.client.user_id,
                    social:       this.client.social,
                    phoneNumbers: this.client.phoneNumbers,
                })
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
