<template>
    <div>
        <v-chip
            link
            :small="small"
            :x-small="xSmall"
            color="success"
            :key="phone.id"
            v-for="phone in phones"
            :href="'tel:' + applyPhoneMask(phone.phoneNumber)"
            :class="'mr-1 mr-md-2 mb-2' + (xSmall ? ' px-2 py-3' : '')">{{ applyPhoneMask(phone.phoneNumber) }}
        </v-chip>
    </div>
</template>

<script>
import applyPhoneMaskMixin from "@/mixin/applyPhoneMaskMixin";

export default {
    name: "ClientPhones",
    mixins: [applyPhoneMaskMixin],
    props: {
        phones: {
            type: Array,
            required: true
        },
        small: {
            type: Boolean,
            default: false
        },
        xSmall: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>