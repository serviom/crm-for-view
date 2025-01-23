<template>
    <div class="container text-center">
        <h1>403 - доступ заборонено</h1>
        <v-btn
            depressed
            color="primary"
            class="mt-4"
            :to="{ name: 'dashboard'}"
        >
            На головну
        </v-btn>
    </div>
</template>

<script>
export default {
}
</script>

<style scoped>

</style>
