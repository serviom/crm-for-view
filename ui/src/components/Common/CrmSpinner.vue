<template>
    <v-progress-circular
        v-if="show"
        :size="size || 25"
        indeterminate
        color="primary"
    ></v-progress-circular>
</template>

<script>
export default {
    props: ['show', 'size'],
}
</script>

<style scoped>

</style>
