<template>
    <v-list-item
        class="d-flex align-items-center justify-content-center pa-0 comment-item"
        style="min-height: inherit;"
    >
        <v-list-item-avatar class="my-1">
            <v-icon v-if="multiple" color="blue">mdi-comment-text-multiple-outline</v-icon>
            <v-icon v-else color="blue">mdi-comment-text-outline</v-icon>
        </v-list-item-avatar>

        <v-list-item-content style="overflow: visible">
            <v-row>
                <v-col cols="12" md="9" class="comment-text pl-0">
                    <div v-if="item.log && item.log.old" class="stage-changed">
                        <span v-text="item.log.old"></span>
                        <v-icon class="mx-3" color="error">mdi-ray-start-arrow</v-icon>
                        <span v-text="item.log.new"></span>
                    </div>
                    <span v-text="item.title" class="text-break"></span>
					<span v-if="!!item.log && !!item.log.link" class="ml-1">
						<a :href="item.log.link" target="_blank">
							<span v-if="!!item.log.domain" v-text="item.log.domain" class="mr-1"></span>
							<v-icon color="info" x-small>mdi-open-in-new</v-icon>
						</a>
					</span>
                </v-col>
                <v-col cols="12" md="3">
                    <v-list-item-subtitle class="d-flex flex-column justify-content-start align-items-end pr-2 overflow-visible">
                        <div v-text="item.name" class="comment-author"></div>
                        <div v-text="item.date" class="comment-date text-md-right"></div>
                    </v-list-item-subtitle>
                </v-col>
            </v-row>
        </v-list-item-content>
    </v-list-item>
</template>

<script>
export default {
    name: "CommentItem",
    props: {
        item: {
            type: Object,
            required: true
        },
        multiple: {
            type: Boolean,
            default: false
        }
    },
}
</script>

<style scoped>
.comment-author,
.comment-date {
    font-size: 12px;
    opacity: 0.5;
    text-align: right;
    margin-top: 3px;
}
.comment-date {
    white-space: nowrap;
    font-size: 10px;
    margin-top: 5px;
}
.stage-changed {
    font-size: 12px;
}
</style>
