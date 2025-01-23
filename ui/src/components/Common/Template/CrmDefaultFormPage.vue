<template>
    <form>
        <v-container fluid>
            <v-row>
                <v-col
                    cols="12"
                    sm="6"
                >
                    <div class="h2">{{ title }}</div>
                </v-col>
                <v-col
                    cols="12"
                    sm="6"
                >
                    <crm-default-forms-controls
                        :editMode="editMode"
                        :isShowSpinner="isShowSpinner"
                        :link="link"
                        :create="create"
                        :edit="edit"
                        :isScrollable="true"
                    ></crm-default-forms-controls>
                </v-col>
                <v-col
                    cols="12"
                    sm="12"
                >
                    <slot></slot>
                </v-col>
                <v-col
                    cols="12"
                    sm="12"
                >
                    <crm-default-forms-controls
                        :editMode="editMode"
                        :isShowSpinner="isShowSpinner"
                        :link="link"
                        :create="create"
                        :edit="edit"
                        :isScrollable="false"
                    ></crm-default-forms-controls>
                </v-col>
            </v-row>
        </v-container>
    </form>
</template>

<script>
import CrmDefaultFormsControls from "./CrmDefaultFormsControls";
export default {
    props: [
        'editMode',
        'title',
        'isShowSpinner',
        'link',
        'create',
        'edit',
    ],
    components: {
        CrmDefaultFormsControls
    },
}
</script>

<style scoped>
.container--fluid {
    max-width: 100%;
}
</style>
