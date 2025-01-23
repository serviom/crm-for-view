<template>
    <div
        v-scroll="onScroll"
        :class="[
            isPositionFixed ? 'position-fixed' : '' ,
            isScrollable ? 'd-none d-md-flex justify-end' : 'd-flex d-md-none justify-center',
        ]"
        class="page-controls"
    >
        <v-btn
            v-if="!editMode"
            :disabled="isShowSpinner"
            class="mr-4"
            @click="create"
            color="primary"
        >
            <span v-if="isShowSpinner">
                <v-progress-circular
                    :size="25"
                    indeterminate
                    color="grey"
                ></v-progress-circular>
            </span>
            <span v-else>Створити</span>
        </v-btn>
        <v-btn
            v-if="editMode"
            :disabled="isShowSpinner"
            class="mr-4"
            @click="edit"
            color="primary"
        >
            <span v-if="isShowSpinner">
                <v-progress-circular
                    :size="25"
                    indeterminate
                    color="grey"
                ></v-progress-circular>
            </span>
            <span v-else>Редагувати</span>
        </v-btn>
        <router-link :to="link">
            <v-btn
                color="secondary"
            >
                Скасувати
            </v-btn>
        </router-link>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    props: [
        'editMode',
        'isShowSpinner',
        'link',
        'create',
        'edit',
        'isScrollable',
    ],

    data() {
        return {
            isPositionFixed: false,
            isMobile: false,
        };
    },

    beforeDestroy () {
        if (typeof window === 'undefined') return

        window.removeEventListener('resize', this.onResize, { passive: true })
    },

    mounted () {
        this.onResize()

        window.addEventListener('resize', this.onResize, { passive: true })
    },

    methods: {
        ...mapActions({
            setIsShowUserWidget: 'NavBarModule/setIsShowUserWidget',
        }),

        onResize () {
            if (typeof window === 'undefined' || !this.isScrollable) return;
            if (window.innerWidth < 960) {
                this.isMobile = true;
                this.setIsShowUserWidget(true);
            } else {
                this.isMobile = false;
                this.setIsShowUserWidget(!this.isPositionFixed);
            }
        },


        onScroll (e) {
            if (typeof window === 'undefined' || !this.isScrollable) return;
            const top = window.pageYOffset ||   e.target.scrollTop || 0;
            if (top > 50) {
                this.isPositionFixed = true;
                this.setIsShowUserWidget( this.isMobile);
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
