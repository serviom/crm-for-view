<template>
    <div class="pa-3">
        <div class="d-flex justify-content-between align-items-center">
            <router-link
                v-if="isEnableNewItemBtn"
                :to="newItemBtnLink"
            >
                <v-btn
                    color="primary"
                    class="mb-3"
                >
                    <v-icon>mdi-plus</v-icon>{{ newItemBtnTitle }}
                </v-btn>
            </router-link>
            <router-link
                v-if="isAdditionalBtn"
                :to="additionalBtnLink"
            >
                <v-btn
                    color="primary"
                    class="mb-3"
                    :icon="additionalIslBtn"
                >
                    <v-icon
                        :large="additionalIslBtn"
                    >{{ additionalBtnIcon }}</v-icon>{{ additionalBtnTitle }}
                </v-btn>
            </router-link>
        </div>
        <slot name="filters"></slot>
        <slot name="table"></slot>
        <crm-dialog
            :isShowDialog="isShowDeleteDialog"
            :isShowSpinner="isShowDeletionSpinner"
            :isAction="true"
            maxWidth="600"
            color="warning"
            actionBtnText="Видалити"
            defaultBtnText=""
            cancelBtnText=""

            @successEvent="deleteItemCallback"
            @closeDialog="closeDialog"
        >
            <template v-slot:info-title>
                Увага!
            </template>

            <template v-slot:info-text>
                Ви дійсно хочете видалити {{ deleteItemTitle }}
                <b
                    v-if="itemToDelete && itemToDeleteProperty"
                >{{ itemToDelete[itemToDeleteProperty] }}</b>?
            </template>
        </crm-dialog>
    </div>
</template>

<script>
import CrmDialog from "./CrmDialog";
export default {
    props: {
        isEnableNewItemBtn: {
            type: Boolean
        },
        newItemBtnLink: {
            type: Object
        },
        newItemBtnTitle: {
            type: String
        },
        isShowDeleteDialog: {
            type: Boolean
        },
        isShowDeletionSpinner: {
            type: Boolean
        },
        deleteItemCallback: {
            type: Function
        },
        deleteItemTitle: {
            type: String
        },
        itemToDelete: {
            type: Object
        },
        itemToDeleteProperty: {
            type: String
        },
        isAdditionalBtn: {
            type: Boolean,
            default: false
        },
        additionalBtnLink: {
            type: Object,
            default: ()=>{return {}}
        },
        additionalBtnIcon: {
            type: String,
            default: 'mdi-comment-question'
        },
        additionalBtnTitle: {
            type: String,
            default: ''
        },
        additionalIslBtn: {
            type: Boolean,
            default: false
        }
    },
    components: {
        CrmDialog,
    },
    methods: {
        closeDialog() {
            this.$emit("closeDialog");
        }
    }
}
</script>

<style scoped>

</style>
