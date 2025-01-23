<template>
    <v-container fluid class="pa-0">
        <v-row>
            <v-col
                cols="12"
                md="4"
            >
                <div class="d-flex flex-column align-items-center">
                    <div
                        class="position-relative my-3"
                        @mouseenter="isShowDeleteBtn = true"
                        @mouseleave="isShowDeleteBtn = false"
                    >
                        <v-img
                            v-if="getProfile.avatar"
                            class="avatar-image rounded-circle"
                            :aspect-ratio="1/1"
                            :src="getProfile.avatar"
                        ></v-img>
                        <v-icon
                            v-else
                            :size="120"
                            class="no-avatar"
                        >mdi-account</v-icon>
                        <div
                            v-if="isShowDeleteBtn && getProfile.avatar"
                            class="delete-icon-wrapper d-flex justify-center align-items-center"
                            @click.stop="showDeleteAvatarDialog"
                        >
                            <v-card class="delete-icon cursor-pointer rounded-circle pa-3">
                                <v-icon
                                    :size="30"
                                    color="warning"
                                >mdi-delete</v-icon>
                            </v-card>
                        </div>
                    </div>
                    <v-simple-table class="w-100">
                        <template v-slot:default>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center py-3">
                                        <span class="text-h5 text-break">{{ getProfile.name }}</span><br>
                                        <span>{{ getProfile.roleName }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Телефон</b></td>
                                    <td class="text-right">{{ getProfile.phoneNumber }}</td>
                                </tr>
                                <tr>
                                    <td><b>E-mail</b></td>
                                    <td class="text-right">{{ getProfile.email }}</td>
                                </tr>
                                <tr>
                                    <td><b>Telegram</b></td>
                                    <td class="text-right">
                                        <v-btn
                                            v-if="getProfile.telegram_id"
                                            text
                                            color="warning"
                                            @click="disconnectTelegram"
                                        >
                                            Відключити
                                        </v-btn>
                                        <v-btn
                                            v-else
                                            text
                                            color="primary"
                                            @click="connectTelegram"
                                        >
                                            Підключити
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                    <v-btn
                        color="primary"
                        class="w-100 mt-6"
                        @click="switchEditForm"
                    >
                        Редагувати
                    </v-btn>
                </div>
            </v-col>
            <v-col
                v-if="isShowEditForm"
                cols="12"
                md="8"
            >
                <form @submit.prevent="saveProfile">
                    <v-container fluid>
                        <v-row>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                                <v-text-field
                                    label="ПІБ"
                                    v-model="editProfileModel.name"
                                    :error-messages="nameErrors"
                                    @input="$v.editProfileModel.name.$touch()"
                                    @blur="$v.editProfileModel.name.$touch()"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                                <v-text-field
                                    v-mask="'+38 (###) ###-####'"
                                    placeholder="+38 __________"
                                    @focus="editProfileModel.phoneNumber = (editProfileModel.phoneNumber ? editProfileModel.phoneNumber : '+38 (')"
                                    label="Телефон"
                                    v-model="editProfileModel.phoneNumber"
                                    :error-messages="phoneNumberErrors"
                                    @input="$v.editProfileModel.phoneNumber.$touch()"
                                    @blur="$v.editProfileModel.phoneNumber.$touch()"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                                <v-text-field
                                    label="E-mail"
                                    v-model="editProfileModel.email"
                                    :error-messages="emailErrors"
                                    @input="$v.editProfileModel.email.$touch()"
                                    @blur="$v.editProfileModel.email.$touch()"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                                <v-file-input
                                    accept="image/png, image/jpeg, image/bmp"
                                    prepend-icon="mdi-camera"
                                    label="Аватар"
                                    v-model="editProfileModel.avatar"
                                ></v-file-input>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                            >
                                <v-text-field
                                    type="password"
                                    label="Новий пароль"
                                    autocomplete="new-password"
                                    v-model="editProfileModel.password"
                                    :error-messages="passwordErrors"
                                    @input="$v.editProfileModel.password.$touch()"
                                    @blur="$v.editProfileModel.password.$touch()"
                                    :append-icon="isShowEye ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="isShowEye ? 'text' : 'password'"
                                    @click:append="isShowEye = !isShowEye"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="12"
                            >
                                <v-btn
                                    color="primary"
                                    type="submit"
                                    class="mr-3"
                                >
                                    Зберегти
                                </v-btn>
                                <v-btn
                                    color="secondary"
                                    type="submit"
                                    @click="isShowEditForm = false"
                                >
                                    Скасувати
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </form>
            </v-col>
        </v-row>
        <crm-dialog
            :isShowDialog="isShowDeleteAvatarDialog"
            :isShowSpinner="isShowDeleteAvatarSpinner"
            :isAction="true"
            maxWidth="600"
            color="warning"
            actionBtnText="Видалити"
            defaultBtnText=""
            cancelBtnText=""

            @successEvent="deleteAvatar"
            @closeDialog="closeDeleteAvatarDialog"
        >
            <template v-slot:info-title>
                Увага!
            </template>

            <template v-slot:info-text>
                Ви дійсно хочете видалити ваш аватар?
            </template>

        </crm-dialog>
    </v-container>
</template>

<script>
import CrmDialog from "../../../Common/Template/CrmDialog";
import { required, minLength, maxLength, email } from 'vuelidate/lib/validators'
import {mapActions, mapGetters} from "vuex";
import {cloneDeep as _cloneDeep} from 'lodash';
import ProfileModel from "./../../../../models/ProfileModel"

export default {
    components: {
        CrmDialog,
    },
    validations: {
        editProfileModel: {
            name: {required, maxLength: maxLength(100)},
            email: {required, maxLength: maxLength(100), email},
            phoneNumber: {maxLength: maxLength(100)},
            password: {minLength: minLength(8), maxLength: maxLength(100)},
        }
    },
    data() {
        return {
            isShowDeleteAvatarDialog: false,
            isShowDeleteAvatarSpinner: false,
            isShowDeleteBtn: false,
            isShowEditForm: false,
            editProfileModel: _cloneDeep(ProfileModel),
            responseErrors: {},
            isShowSpinner: false,
            isShowEye: false,
        };
    },
    computed: {
        ...mapGetters({
            getProfile: 'ProfileModule/getProfile',
        }),

        nameErrors() {
            let errors = [];
            if (!this.$v.editProfileModel.name.$dirty) return errors;
            !this.$v.editProfileModel.name.maxLength && errors.push('Максимальна довжина 100 символів');
            !this.$v.editProfileModel.name.required && errors.push('Поле користувач обов\'язкове');
            return errors
        },

        emailErrors() {
            let errors = []
            if (!this.$v.editProfileModel.email.$dirty) return errors
            !this.$v.editProfileModel.email.maxLength && errors.push('Максимальна довжина 100 символів')
            !this.$v.editProfileModel.email.required && errors.push('Поле email обов\'язкове');
            !this.$v.editProfileModel.email.email && errors.push('Введіть валідний email');
            if (!!this.responseErrors.email) {
                errors = errors.concat(this.responseErrors.email);
            }
            return errors
        },

        phoneNumberErrors() {
            let errors = []
            if (!this.$v.editProfileModel.phoneNumber.$dirty) return errors
            !this.$v.editProfileModel.phoneNumber.maxLength && errors.push('Максимальна довжина 100 символів');
            if (!!this.responseErrors.phoneNumber) {
                errors = errors.concat(this.responseErrors.phoneNumber);
            }
            return errors
        },

        passwordErrors() {
            let errors = []
            if (!this.$v.editProfileModel.password.$dirty) return errors
            !this.$v.editProfileModel.password.minLength && errors.push('Мінімальна довжина 8 символів')
            !this.$v.editProfileModel.password.maxLength && errors.push('Максимальна довжина 100 символів');
            return errors
        },
    },
    methods: {
        ...mapActions({
            setProfile: 'ProfileModule/setProfile',
            incrementSpinnerCounter: 'SpinnerModule/incrementSpinnerCounter',
            decrementSpinnerCounter: 'SpinnerModule/decrementSpinnerCounter',
        }),

        connectTelegram(){
            this.axios
                .post(`telegram/connect`, {})
                .then(response => {
                    if(response.data.data.redirect) window.open(response.data.data.redirect, '_blank')
                })
                .catch(error => {
                    console.log(error)
                })
        },

        disconnectTelegram(){
            this.incrementSpinnerCounter()

            this.axios
                .post(`telegram/disconnect`, {})
                .then(response => {
                    this.setProfile(response.data.data);
                    let message = response.data.message || "Success"
                    this.eventHub.$emit("doShowSnackbarEvent", true, message, 'success', 5000)

                })
                .catch(error => {
                    console.log(error)
                })
                .then(()=>{
                    this.decrementSpinnerCounter();
                })
        },

        closeDeleteAvatarDialog () {
            this.isShowDeleteAvatarDialog = false;
        },

        showDeleteAvatarDialog () {
            this.isShowDeleteAvatarDialog = true;
        },

        deleteAvatar () {
            this.isShowDeleteAvatarSpinner = true;

            this.axios
                .delete(`profile/avatar`)
                .then(response => {
                    let message = response.data.message;
                    let profile = response.data.data;
                    this.setProfile(profile);
                    this.eventHub.$emit("doShowSnackbarEvent" , true, message, 'success', 5000);
                })
                .catch(error => {
                })
                .then(() => {
                    this.closeDeleteAvatarDialog();
                    this.isShowDeleteAvatarSpinner = false;
                });
        },

        switchEditForm() {
            this.isShowEditForm = !this.isShowEditForm;
            this.editProfileModel = _cloneDeep(this.getProfile);
            this.editProfileModel.avatar = null;
            this.$v.$reset();
        },

        saveProfile () {
            this.$v.$touch();

            if (this.$v.$invalid ) {
                return;
            }

            this.incrementSpinnerCounter();
            const data = new FormData();
            data.append('avatar', this.editProfileModel.avatar);
            data.append('name', this.editProfileModel.name);
            data.append('email', this.editProfileModel.email);
            data.append('phoneNumber', this.editProfileModel.phoneNumber);
            data.append('password', this.editProfileModel.password);

            this.axios
                .post(`profile`, data
                )
                .then(response => {
                    this.editProfileModel.avatar = null;
                    let message = response.data.message;
                    let profile = response.data.data;
                    this.responseErrors = {};
                    this.setProfile(profile);
                    this.eventHub.$emit("doShowSnackbarEvent" , true, message, 'success', 5000);
                })
                .catch(error => {
                    if (error.status === 422) {
                        this.responseErrors = error.data.errors;
                    }
                })
                .then(() => {
                    this.decrementSpinnerCounter();
                });
        }
    }
}
</script>

<style scoped lang="scss">

.avatar-image {
    width: 150px;
    max-width: 100%;
    border: 1px solid grey;
    border-radius: 100%;
}

.no-avatar {
    width: 150px;
    height: 150px;
    border: 1px solid grey;
    border-radius: 100%;
}

.delete-icon-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
</style>
