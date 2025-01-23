<template>
    <crm-default-form-page
        :editMode="editMode"
        :title="title"
        :isShowSpinner="isShowSpinner"
        :link="{ name: 'clients'}"
        :create="create"
        :edit="edit"
    >
        <v-row>
            <v-col
                cols="12"
                md="6"
            >
                <v-text-field
                    ref="fio"
                    v-model="client.fio"
                    :error-messages="fioErrors"
                    :counter="100"
                    label="ПІБ"
                    @input="$v.client.fio.$touch()"
                    @blur="$v.client.fio.$touch()"
                ></v-text-field>
                <div
                    :key="index"
                    v-for="(phoneNumber,index) in client.phoneNumbers"
                >
                    <div class="d-flex align-items-center">
                        <v-text-field
                            :ref="'phone' + index"
                            class="flex-grow-1 mr-3"
                            v-mask="'+38 (###) ###-####'"
                            placeholder="+38 (###) ###-####"
                            :error-messages="phoneNumbersErrors(index)"
                            v-model="phoneNumber.phoneNumber"
                            label="Телефон"
                            @keyup="checkNumber"
                        >
                        </v-text-field>
                        <v-btn
                            fab small
                            v-if="index === 0"
                            class="flex-grow-0 w-auto px-2"
                            color="info"
                            @click.stop="addPhoneNumber(index)"
                        >
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                        <v-btn
                            fab small
                            v-else
                            class="flex-grow-0 w-auto px-2"
                            color="light"
                            @click.stop="deletePhoneNumber(index)"
                        >
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </div>
                </div>
                <v-alert
                    v-if="isExistPhone"
                    class="pa-0 phone-alert"
                    dense outlined :color="isExistPhoneData.user_id ? 'error' : 'teal'"
                >
                  <div v-if="isExistPhoneData.fio">
                    Клієнт
                    <v-btn depressed small
                           style="height: 20px;"
                           v-if="$auth.check(['SuperAdmin'] ,'permissions') || !isExistPhoneData.user_id"
                           class="justify-start text-capitalize show-client px-2 mb-1"
                           :color="isExistPhoneData.user_id ? 'rgb(255 0 0 / 20%)' : 'rgb(0 150 136 / 30%)'"
                           @click="showClientCard = true"
                    >{{ isExistPhoneData.fio }}
                    </v-btn>
                    <b v-else>{{ isExistPhoneData.fio }}</b>
                    з номером телефону
                    <b>{{ isExistPhoneData.phone_numbers[0].phoneNumber }}</b>
                    вже існує
                    <span v-if="isExistPhoneData.user_id">та закріплений за користувачем
                            <v-btn target="_blank"
                                   v-if="$auth.check(['SuperAdmin', 'users.update'] ,'permissions')"
                                   depressed small style="height: 20px;"
                                   class="justify-start text-capitalize show-client px-2"
                                   :color="isExistPhoneData.user_id ? 'rgb(255 0 0 / 20%)' : 'rgb(0 150 136 / 30%)'"
                                   :to="{ name: 'users.update', params: { id: isExistPhoneData.user.id } }"
                            >{{ isExistPhoneData.user.name }}</v-btn>
                            <b v-else>{{ isExistPhoneData.user.name }}</b>
                        </span>
                    <span v-else>та ні за ким не закріплений. Ви можете з ним працювати.</span>
                  </div>
                </v-alert>
<!--                TODO поки що не треба -->
<!--                <v-text-field-->
<!--                    v-model="client.social"-->
<!--                    :error-messages="socialErrors"-->
<!--                    :counter="250"-->
<!--                    label="Сторінка в  соц мережі"-->
<!--                    @input="$v.client.social.$touch()"-->
<!--                    @blur="$v.client.social.$touch()"-->
<!--                ></v-text-field>-->
                <v-autocomplete
                    v-model="client.income_source_id"
                    :items="getIncomeSources"
                    :clearable="true"
                    item-text="title"
                    item-value="id"
                    label="Джерело надходження"
                    auto-select-first
                ></v-autocomplete>
                <v-text-field
                    v-if="client.income_source_id && getIncomeSources.length && getIncomeSources.find(item => item.id === client.income_source_id)['with_comment']"
                    v-model="client.income_source"
                    :error-messages="incomeSourceErrors"
                    :counter="250"
                    label="Джерело надходження, коментар"
                    @input="$v.client.income_source.$touch()"
                    @blur="$v.client.income_source.$touch()"
                ></v-text-field>
                <v-autocomplete
                    v-if="$auth.check(['SuperAdmin','users.viewAny'] ,'permissions')"
                    v-model="client.user_id"
                    :items="getAllUsersList"
                    :clearable="true"
                    item-text="name"
                    item-value="id"
                    label="Користувач"
                ></v-autocomplete>
                <v-textarea
                    v-model="client.description"
                    :error-messages="descriptionErrors"
                    :counter="1000"
                    label="Додаткова інформація про клієнта"
                    class="mt-2"
                    @input="$v.client.description.$touch()"
                    @blur="$v.client.description.$touch()"
                ></v-textarea>
            </v-col>

            <v-col cols="12" md="6" class="px-md-6" v-if="!editMode">
                <order-form
                    class="orders-list"
                    :buttons="false"
                    :item="temp"
                    :toggleDialog="toggleOrderForm"
                    @saveOrder="saveOrder"
                />
            </v-col>

            <crm-dialog
                :isShowDialog="isShowValidationDialog"
                :isAction="false"
                :isCancelBtn="false"
                color="warning"
                defaultBtnText="Закрити"
                @successEvent="closeValidationDialog"
                @closeDialog="closeValidationDialog"
            >
                <template v-slot:info-title>
                    Увага!
                </template>

                <template v-slot:info-text>
                    <div v-if="responseData.phoneNumber_unique_user">
                        Клієнт
                        <router-link :to="{ name: 'clients.update',params: { id: responseData.phoneNumber_unique_client.id } }">
                            <b>{{ responseData.phoneNumber_unique_client.fio }}</b>
                        </router-link>
                        з номером телефону
                        <b>{{ responseData.phoneNumber_unique_phoneNumber }}</b>
                        закріплений за користувачем
                        <router-link :to="{ name: 'users.update',params: { id: responseData.phoneNumber_unique_user.id } }">
                            <b>{{ responseData.phoneNumber_unique_user.name }}</b>
                        </router-link>
                    </div>
                    <div v-else-if="responseData.phoneNumber_unique_client">
                        Клієнт
                        <router-link :to="{ name: 'clients.update',params: { id: responseData.phoneNumber_unique_client.id } }">
                            <b>{{ responseData.phoneNumber_unique_client.fio }}</b>
                        </router-link>
                        з номером телефону
                        <b>{{ responseData.phoneNumber_unique_phoneNumber }}</b>
                        вже існує
                    </div>
                    <div v-else>
                        <div
                            v-for="(item, k) in responseData"
                            :key="k"
                        >
                            <b
                                v-for="(error, kk) in item"
                                :key="kk"
                            >{{ error[0] }}</b>
                        </div>
                    </div>
                </template>

            </crm-dialog>
        </v-row>

        <v-bottom-sheet
            inset fullscreen scrollable
            transition="slide-x-transition"
            elevation="0"
            v-model="showClientCard"
        >
            <client-card
                :client="isExistPhoneData"
                :reload="showClientCard"
                :hide="()=>{ this.showClientCard=false }"
                @joinClient="joinClient"
            />
        </v-bottom-sheet>

    </crm-default-form-page>
</template>

<script>
import CrmDefaultFormPage from "@/components/Common/Template/CrmDefaultFormPage";
import ClientCard from "@/components/Pages/Dashboard/Clients/ClientCard";
import CrmDialog from "@/components/Common/Template/CrmDialog";
import OrderForm from "@/components/Pages/Dashboard/Orders/Form";
import OrderModel from "@/models/OrderModel"
import { validationMixin } from 'vuelidate'
import {filter as _filter, cloneDeep as _cloneDeep} from 'lodash';
import {mapActions, mapGetters} from "vuex";
import { required, requiredIf, maxLength, minLength } from 'vuelidate/lib/validators'
import ClientModel from "@/models/ClientModel";

export default {
    mixins: [validationMixin],
    props: ['editMode' , 'responseErrors', 'title'],
    components: {
        OrderForm,
        ClientCard,
        CrmDefaultFormPage,
        CrmDialog
    },

    data() {
        return {
            isShowSpinner: false,
            isShowValidationDialog: false,
            responseData: {},
            showOrderForm: false,
            temp: _cloneDeep(OrderModel),

            timer: null,
            isExistPhone: false,
            isExistPhoneData: null,

            showClientCard: false,
        };
    },

    validations() {
        return {
            client: {
              fio: {required, maxLength: maxLength(100)},
              //TODO поки що не треба
              // social: {
              //     requiredIf:
              //         !this.client.phoneNumbers.filter(item => {
              //             item.phoneNumber.length > 15
              //         }).length
              //     ,
              //     maxLength: maxLength(250)
              // },
              income_source: {maxLength: maxLength(250)},
              description: {maxLength: maxLength(1000)},
              user_id: {},
                phoneNumbers: {
                    maxLength: maxLength(10),
                    minLength: minLength(1),
                    $each: {
                        phoneNumber: {
                            required,
                            //TODO поки що не треба
                            // requiredIf: !this.client.social,
                            maxLength: maxLength(18),
                            minLength: minLength(18),
                            isUnique(value) {
                                return _filter(this.client.phoneNumbers, {phoneNumber: value}).length < 2;
                            },
                        }
                    }
                },
            }
        }
    },

    computed: {
        ...mapGetters({
            getClient: 'ClientsModule/getClient',
            getAllUsersList: 'ClientsModule/getAllUsers',
            getIncomeSources: 'IncomeSourcesModule/getList',
        }),

        client: {
            get() {
                return this.getClient;
            },
            set(value) {
                this.setClient(value);
            }
        },

        fioErrors() {
            let errors = [];
            if (!this.$v.client.fio.$dirty) return errors;
            !this.$v.client.fio.maxLength && errors.push('Максимальна довжина 100 символів');
            !this.$v.client.fio.required && errors.push('Поле ПІБ обов\'язкове');
            return errors
        },

        descriptionErrors() {
            let errors = []
            if (!this.$v.client.description.$dirty) return errors
            !this.$v.client.description.maxLength && errors.push('Максимальна довжина 1000 символів')
            return errors
        },

        incomeSourceErrors() {
            let errors = [];
            if (!this.$v.client.income_source.$dirty) return errors;
            !this.$v.client.income_source.maxLength && errors.push('Максимальна довжина 250 символів');
            return errors
        },

      //TODO поки що не треба
      //   socialErrors() {
      //       let errors = [];
      //       if (!this.$v.client.social.$dirty || !this.$v.client.phoneNumbers.$invalid) return errors;
      //       !this.$v.client.social.maxLength && errors.push('Максимальна довжина 250 символів');
      //       !this.$v.client.social.required && errors.push('Поле Сторінка соцмережі обов\'язкове без телефону');
      //       return errors
      //   },
    },

    mounted() {
        this.$nextTick(() => {
            this.$refs.fio.focus();
        })

        this.eventHub.$on("doShowClientValidationDialog", (responseData) => {
            this.responseData = responseData;
            this.showValidationDialog();
        })

        this.getHandbooks()
    },

    beforeDestroy() {
        this.eventHub.$off("doShowClientValidationDialog");
    },

    methods: {
        ...mapActions({
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
            setIncomeSourcesList: 'IncomeSourcesModule/setList',
            setClient: 'ClientsModule/setClient',
        }),

        toggleOrderForm() {
            this.showOrderForm = ! this.showOrderForm
        },

        saveOrder(item) {
            this.temp = item
        },

        phoneNumbersErrors(index) {
            let errors = []
            // TODO поки не треба
            // if (!this.$v.client.phoneNumbers.$each[index].$dirty || !this.$v.client.social.$invalid) return errors

            if (!this.$v.client.phoneNumbers.$each[index].$dirty ) return errors

            !this.$v.client.phoneNumbers.$each[index].phoneNumber.maxLength && errors.push('Максимальна довжина 100 символів');
            !this.$v.client.phoneNumbers.$each[index].phoneNumber.minLength && errors.push('Телефон вказаний не корректно');
            !this.$v.client.phoneNumbers.$each[index].phoneNumber.required && errors.push('Поле телефон обов\'язкове');
            !this.$v.client.phoneNumbers.$each[index].phoneNumber.isUnique && errors.push('Поле телефон містить значення, яке дублюється');

            if (!!this.responseErrors['phoneNumbers.' + index + '.phoneNumber']) {
                errors = errors.concat(this.responseErrors['phoneNumbers.' + index + '.phoneNumber']);
            }

            return errors
        },

        addPhoneNumber(index) {
            this.client.phoneNumbers.push( {
                phoneNumber: ''
            });
            this.$nextTick(() => {
                this.$refs['phone'+ (index + 1)][0].focus();
            });
        },

        deletePhoneNumber(index) {
            this.client.phoneNumbers.splice(index, 1);
        },

        create () {
            this.$v.$touch();

            if (this.$v.$invalid ) {
                return;
            }

            this.$emit('create', this.temp);
        },

        edit () {
            this.$v.$touch();

            if (this.$v.$invalid ) {
                return;
            }

            this.$emit('edit');
        },

        showValidationDialog () {
            this.isShowValidationDialog = true;
        },

        closeValidationDialog () {
            this.isShowValidationDialog = false;
        },

        getHandbooks() {
            this.axios
                .get(`handbook/income_sources`, {})
                .then(response => {
                    this.setIncomeSourcesList(response.data.data)
                })
                .catch(error => {})
                .then(() => {})
        },

        async checkNumber(event) {
            let phone = event.target.value.replace(/\D/g, '').replace(/^38/, '')
            if(phone.length === 10) {
                this.axios
                    .post(`clients/check-phone`, {phone})
                    .then(response => {
                        this.isExistPhone = (response.data.count > 0)

                        if(response.data.data) this.isExistPhoneData = response.data.data
                        else this.isExistPhoneData = _cloneDeep(ClientModel)
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },

        joinClient() {
            this.isExistPhoneData.user_id = this.$auth.user().id
            this.isExistPhoneData.user = {name:this.$auth.user().name}
        },
    },
}
</script>

<style scoped lang="scss">
.v-btn {
    min-width: 150px!important;
}
.v-btn.w-auto{
    min-width: auto!important;
}
.orders-list {
    background: #f7f7f7;
}
.v-btn.show-client {
    min-width: auto!important;
}
.phone-alert {
    border: none !important;
    font-size: 12px;
    line-height: 12px;
    word-break: break-word;
    overflow-wrap: break-word;
    word-wrap: break-word;
    margin-top: -15px;
    padding-right: 40px !important;
}
.phone-alert:not(.teal--text) {
    color: #ff5252 !important;
}
</style>
