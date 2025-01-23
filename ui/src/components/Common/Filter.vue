<template>
    <form @submit.prevent="apply" class="mb-6">
        <v-container fluid class="filter-form pb-4">
            <v-row>
                <template v-for="(filter, i) in filters">
                    <v-col
                        v-if="$auth.check(filter.permissions,'permissions')"
                        :key="i"
                        :cols="filter.width ? filter.width.cols : '12'"
                        :sm="filter.width ? filter.width.sm : '6'"
                        :md="filter.width ? filter.width.md : '4'"
                        :lg="filter.width ? filter.width.lg : '2'"
                    >
                        <v-text-field
                            v-if="(filter.field==='text')"
                            v-model="filter.value"
                            v-mask="filter.mask ? filter.mask : ''"
                            :label="filter.label"
                            @focus="filter.focus ? filter.value = focus(filter) : false"
                            @blur="filter.blur ? filter.value = blur(filter) : false"
                            :placeholder="filter.placeholder ? filter.placeholder : ''"
                            class="fs-14"
                            hide-details
                        ></v-text-field>

                        <v-autocomplete
                            v-if="(filter.field==='select' || filter.field==='multiple') && filter.items.length"
                            v-model="filter.value"
                            :items="autocompleteItems(filter.items)"
                            :item-text="filter.item.text"
                            :item-value="filter.item.value"
                            :label="filter.label"
                            :multiple="filter.field==='multiple'"
                            hide-details
                            clearable
                            :disabled="filter.disabled"
                            :class="filter.field==='multiple' ? 'multiple-select' : ''"
                            class="fs-14"
                        ></v-autocomplete>

                        <v-radio-group
                            v-if="(filter.field==='radio' && filter.items)"
                            v-model="filter.value"
                            row hide-details
                            class="mt-1 d-flex align-items-center fs-14"
                        >
                            <v-radio
                                v-for="(option, k) in filter.items"
                                :key="k"
                                :label="option.label ? option.label : option"
                                :value="option.value ? option.value : option"
                            ></v-radio>
                        </v-radio-group>

                        <v-checkbox
                            v-if="(filter.field==='checkbox')"
                            v-model="filter.value"
                            hide-details
                            checked="false"
                            :label="filter.label"
                            class="fs-14 mt-3"
                        ></v-checkbox>

                        <v-menu
                            v-if="(filter.field==='date')"
                            v-model="calendar"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            min-width="auto"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="dateRangeText"
                                    :label="filter.label"
                                    prepend-icon="mdi-calendar"
                                    :placeholder="filter.placeholder ? filter.placeholder : ''"
                                    readonly hide-details
                                    class="fs-14"
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="filter.value"
                                range
                                no-title
                                scrollable
                                @change="dateRange(filter.value)"
                                locale="uk"
                            ></v-date-picker>
                        </v-menu>

                    </v-col>
                </template>

                <v-col
                    cols="12" sm="6" md="3" lg="2"
                    class="d-flex align-items-center justify-content-end filter-actions"
                >
                    <v-btn
                        color="success"
                        class="mr-3"
                        type="submit"
                    >
                        <v-icon>mdi-magnify</v-icon>
                    </v-btn>
                    <v-btn
                        color="light"
                        @click="resetFilter"
                    >
                        <v-icon>mdi-close-thick</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </form>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: 'FilterForm',
    props: {
        apply: {
            type: Function
        },
        reset: {
            type: Function
        },
    },
    data() {
        return {
            calendar: false,
            dateRangeText: ''
        }
    },
    computed: {
        ...mapGetters({
            getFilter: 'FilterModule/getFilter',
        }),

        filters: {
            get() {
                return this.getFilter
            },
            set(value) {
                this.setFilter(value)
            }
        }
    },
    methods: {
        ...mapActions({
            setFilter: 'FilterModule/setFilter',
        }),

        focus(filter) {
            return filter.value ? filter.value : filter.focus
        },

        blur(filter) {
            return (filter.value.length < filter.blur) ? '' : filter.value
        },

        autocompleteItems(items) {
            return (typeof items==='function') ? items() : items
        },

        resetFilter() {
            this.reset()
            this.dateRangeText = ''
        },

        dateRange(value) {
            let dates = []
            let sorted = []

            value.forEach(function (el) {
                sorted.push(Date.parse(el))
            })

            sorted
                .sort()
                .forEach(function (el) {
                    dates.push(new Date(el).toLocaleDateString('ru-RU', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                    }))
                })

            this.dateRangeText = dates.join(' - ')
        }
    },
}
</script>

<style scoped>
.filter-form {
    background-color: rgba(0,0,0,0.04);
    border-radius: 6px;
}
.filter-actions {
    margin-left: auto;
}
</style>
<style>
.container--fluid {
    max-width: 100%;
}
label {
    margin-bottom: 0 !important;
}
.v-input--radio-group.v-input--radio-group--row .v-radio {
    margin-right: 5px;
}
.v-input--radio-group.v-input--radio-group--row .v-radio:last-child {
    margin-right: 0;
}
.v-application--is-ltr .v-input--selection-controls__input {
    margin-right: 4px;
}
.v-text-field {
    padding-top: 0;
}
.multiple-select.v-select .v-select__slot .v-select__selections {
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.multiple-select.v-select .v-select__slot .v-select__selections .v-select__selection {
    display: inline;
}
.fs-14 {
    font-size: 14px;
}
</style>