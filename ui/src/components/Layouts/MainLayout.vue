<template>
    <v-container class="fill-height">
        <v-row class="justify-center">
            <v-col
                cols="12"
                lg="4"
            >
                <router-view></router-view>
            </v-col>
            <crm-flash-message></crm-flash-message>
        </v-row>
    </v-container>
</template>

<script>
import CrmFlashMessage from "../Common/CrmFlashMessage"
export default {
    components: {
        CrmFlashMessage,
    },
}
</script>

<style scoped lang="scss">
.bg {
    background-color:  royalblue;
}
</style>
