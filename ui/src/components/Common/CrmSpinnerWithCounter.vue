<template>
    <v-progress-linear
        v-if="isShowSpinner"
        :size="size || 25"
        indeterminate
        color="primary"
    ></v-progress-linear>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    props: ['size'],
    data: () => ({
        count: 0
    }),
    computed: {
        ...mapGetters({
            isShowSpinner: 'SpinnerModule/isShowSpinner',
        }),
    },
}
</script>

<style scoped>

</style>
