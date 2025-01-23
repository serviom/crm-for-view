<template>
    <v-container fluid>
        <v-row>
            <v-col
                cols="12"
                md="12"
                class="d-flex justify-content-between"
            >
                <div>
                    <slot name="title"></slot>
                </div>
                <div
                    v-scroll="onScroll"
                    :class="[
                        isPositionFixed ? 'position-fixed' : '' ,
                        'd-flex justify-end',
                    ]"
                    class="page-controls"
                >
                    <router-link :to="link">
                        <v-btn
                            color="secondary"
                        >
                            <span class="d-sm-block d-none">Назад</span>
                            <v-icon color="white" class="d-block d-sm-none">mdi-arrow-u-left-top</v-icon>
                        </v-btn>
                    </router-link>
                </div>
            </v-col>
        </v-row>
        <div>
            <slot name="body"></slot>
        </div>
    </v-container>
</template>

<script>
import {mapActions} from "vuex";

export default {
    props: [
        'link',
    ],
    data() {
        return {
            isPositionFixed: false,
        };
    },

    methods: {
        ...mapActions({
            setIsShowUserWidget: 'NavBarModule/setIsShowUserWidget',
        }),

        onScroll(e) {
            if (typeof window === 'undefined') return;
            const top = window.pageYOffset || e.target.scrollTop || 0;
            if (top > 50) {
                this.isPositionFixed = true;
                this.setIsShowUserWidget(false);
            } else {
                this.isPositionFixed = false;
                this.setIsShowUserWidget(true);
            }
        },
    }
}
</script>

<style scoped lang="scss">
.page-controls {
    &.position-fixed{
        top: 14px;
        right: 24px;
        z-index: 5;
    }
}
</style>
