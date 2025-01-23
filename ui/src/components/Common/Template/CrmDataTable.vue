<template>
    <v-data-table
        :headers="headers"
        :items="items"
        :search="search"
        :items-per-page="itemsPerPage"
        class="elevation-1 set-tbody-d-table-row"
        :footer-props="footerProps"
        :mobile-breakpoint="null"
    >
        <template v-slot:no-data>
            <slot name="no-data"></slot>
        </template>

        <template v-slot:no-results>
            <slot name="no-results"></slot>
        </template>

        <template
            v-slot:item="{ item, index }"
        >
            <slot
                name="item"
                :item="item"
                :index="index"
            ></slot>
        </template>
    </v-data-table>
</template>

<script>
export default {
    props: [
        'headers',
        'items',
        'search',
        'itemsPerPage',
        'footerProps',
    ],
}
</script>

<style scoped>

</style>
