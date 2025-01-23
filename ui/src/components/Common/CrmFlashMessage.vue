<template>
    <v-snackbar
        v-model="snackbar"
        :timeout="timeout"
        :color="color"
    >
        {{ text }}

        <template v-slot:action="{ attrs }">
            <v-btn
                color="white"
                text
                v-bind="attrs"
                @click="snackbar = false"
            >
                &times;
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>
export default {
    data: () => ({
        snackbar: false,
        text: '',
        color: 'success',
        timeout: 2000,
    }),
    mounted() {
        this.eventHub.$on("doShowSnackbarEvent", (snackbar, text, color, timeout) => {
            this.snackbar = snackbar;
            this.text = text;
            this.color = color;
            this.timeout = timeout;
        });
    },
    beforeDestroy() {
        this.eventHub.$off("doShowSnackbarEvent");
    },
}
</script>

<style scoped>

</style>
