<template>
    <v-card
        elevation="2"
        class="pa-6"
    >
        <form>
            <div class="h2 d-flex justify-center">Авторизація</div>
            <v-text-field
                v-model="email"
                :error-messages="emailErrors"
                label="E-mail"
                required
                @input="$v.email.$touch()"
                @blur="$v.email.$touch()"
            ></v-text-field>
            <v-text-field
                type="password"
                v-model="password"
                :error-messages="passwordErrors"
                label="Пароль"
                required
                @input="$v.password.$touch()"
                @blur="$v.password.$touch()"
            ></v-text-field>
            <div class="d-flex justify-center">
                <v-btn
                    :disabled="isShowSpinner"
                    @click="submit"
                    class="justify-center submit mr-3"
                    color="primary"
                >
                    <span v-if="isShowSpinner">
                        <v-progress-circular
                            :size="25"
                            indeterminate
                            color="grey"
                        ></v-progress-circular>
                    </span>
                    <span v-else>Увійти</span>
                </v-btn>
                <router-link :to="{ name: 'index'}">
                    <v-btn
                        class="justify-center submit"
                        color="secondary"
                    >
                        Головна
                    </v-btn>
                </router-link>
            </div>
        </form>
    </v-card>
</template>

<script>
import { required, minLength, email } from 'vuelidate/lib/validators'
export default {
    data() {
        return {
            isShowSpinner: false,
            email: "",
            password: "",
            errors: [],
        };
    },
    validations: {
        email: { required, email },
        password: { required, minLength: minLength(8)  },
    },
    computed: {
        emailErrors () {
            const errors = []
            if (!this.$v.email.$dirty) return errors
            !this.$v.email.email && errors.push('Має бути валідний e-mail')
            !this.$v.email.required && errors.push('Поле E-mail обов\'язкове')
            return errors
        },
        passwordErrors () {
            const errors = []
            if (!this.$v.password.$dirty) return errors
            !this.$v.password.minLength && errors.push('Мінімальна довжина 8 символів')
            !this.$v.password.required && errors.push('Поле пароль обов\'язкове')
            return (errors.length) ? errors : this.errors;
        },
    },
    created() {
        if (this.$auth.check()) {
            this.$router.push({ name: 'dashboard' }).catch(()=>{});
        }
    },
    methods: {
        submit () {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.errors = [];
            this.isShowSpinner = true;

            // https://websanova.com/docs/vue-auth/guides/startup
            this.$auth
                .login({
                    data: {
                        email: this.email,
                        password: this.password,
                    }, // Axios
                    remember: null,
                    fetchUser: true,
                    staySignedIn: true,
                })
                .catch(error => {
                    let message = error.data.message || "Щось пішло не так :/"
                    this.eventHub.$emit("doShowSnackbarEvent", true, message, 'warning', 5000);
                })
                .finally(() => {
                    this.isShowSpinner = false;
                });
        }
    }
}
</script>

<style scoped lang="scss">
.v-btn {
    min-width: 120px!important;
}
</style>
