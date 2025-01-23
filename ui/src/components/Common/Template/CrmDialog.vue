<template>
    <v-dialog
        transition="dialog-bottom-transition"
        :max-width="maxWidth || 600"
        v-model="isShow"
    >
        <template v-slot:default="dialog">
            <v-card class="pa-0 pb-6">
                <v-toolbar
                    :color="color"
                    dark
                    class="text-h4"
                >
                    <slot name="info-title"></slot>
                </v-toolbar>
                <v-card-text>
                    <div class="pt-5">
                        <slot name="info-text"></slot>
                    </div>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-btn
                        v-if="isAction"
                        :disabled="isShowSpinner || disableActionBtnText"
                        :color="color"
                        class="text-white mr-4"
                        @click="successEvent"
                    >
                            <span v-if="isShowSpinner">
                                <v-progress-circular
                                    :size="25"
                                    indeterminate
                                    color="grey"
                                ></v-progress-circular>
                            </span>
                        <span v-else>{{ actionBtnText }}</span>
                    </v-btn>
                    <v-btn
                        v-else
                        :color="color"
                        class="text-white mr-4"
                        @click="successEvent"
                    >
                        <span>{{ defaultBtnText }}</span>
                    </v-btn>
                    <v-btn
                      v-if="isAdditionalBtn"
                      :disabled="isShowSpinner"
                      :color="color"
                      class="text-white mr-4"
                      @click="additionalEvent"
                    >
                      <span v-if="isShowSpinner">
                          <v-progress-circular
                              :size="25"
                              indeterminate
                              color="grey"
                          ></v-progress-circular>
                      </span>
                      <span v-else>{{ additionalBtnText }}</span>
                    </v-btn>
                    <v-btn
                        v-if="(isCancelBtn === null) ? true : isCancelBtn"
                        @click="closeDialog"
                    >
                        {{ cancelBtnText || 'Скасувати' }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
</template>

<script>
export default {
    props: {
		maxWidth: {type: String},
		color: {type: String},
		isShowDialog: {type: Boolean, default: false},
		isShowSpinner: {type: Boolean, default: false},
		isAction: {type: Boolean, default: false},
		isAdditionalBtn: {type: Boolean, default: false},
		isCancelBtn: {type: Boolean, default: false},
		actionBtnText: {type: String, default: ''},
		defaultBtnText: {type: String, default: ''},
		cancelBtnText: {type: String, default: ''},
		additionalBtnText: {type: String, default: ''},
    disableActionBtnText: {type: Boolean, default: false}
	},
    data() {
        return {
            isShow: false,
        };
    },
    watch: {
        isShowDialog: function (val) {
            this.isShow = val;
        },
        isShow: function (val){
             if (!val) {
                 this.$emit("closeDialog");
             }
        },
    },
    methods: {
        successEvent() {
            this.$emit("successEvent");
        },
		additionalEvent() {
			this.$emit("additionalEvent");
		},
        closeDialog() {
            this.$emit("closeDialog");
        }
    },
}
</script>

<style scoped lang="scss">
.v-btn {
    min-width: 150px!important;
}
</style>
