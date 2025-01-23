<template>
    <v-data-table
        :headers="headers"
        :items="items"
        :sort-by.sync="sortBy"
        :mustSort="mustBeSorted"
        :search="search"
        :items-per-page="itemsPerPage"
        class="elevation-1 set-tbody-d-table-row"
        :footer-props="footerProps"
        :options.sync="innerOptions"
        :server-items-length="total"
        :mobile-breakpoint="null"
        :sort-desc="true"
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
        'options',
        'serverItemsLength',
        'sort',
        'mustSort'
    ],
    data() {
        return {
            total: 0,
            innerOptions: this.options,
            sortBy: this.sort,
            mustBeSorted: this.mustSort
        };
    },
    watch: {
        innerOptions: {
            handler () {
                this.$emit('update:options', this.innerOptions)
            },
            deep: true,
        },

        serverItemsLength: function (val) {
            this.total = val;
        }
    },


}
</script>

<style scoped>

</style>
