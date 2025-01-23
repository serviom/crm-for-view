<template>
    <v-card class="mb-4">
        <div class="w-100 d-flex flex-no-wrap justify-space-between overflow-hidden">
          <div class="d-flex flex-column justify-space-between pa-2">
            <v-hover v-slot="{ hover }" class="cursor-pointer d-none">
              <v-icon v-if="hover" dense>mdi-menu-swap-outline</v-icon>
              <v-icon v-else dense>mdi-menu</v-icon>
            </v-hover>

            <v-tooltip right color="primary">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                    icon x-small
                    v-bind="attrs"
                    v-on="on"
                    @click="archiveAudio(audio)"
                >
                  <v-hover v-slot="{ hover }">
                    <v-icon v-if="hover" color="primary">mdi-archive</v-icon>
                    <v-icon v-else>mdi-archive</v-icon>
                  </v-hover>
                </v-btn>
              </template>
              <span v-if="audio.archive">З архіву</span>
              <span v-else>В архів</span>
            </v-tooltip>
          </div>

          <v-card-text class="pa-2 d-flex align-items-center">
            <v-row>
              <v-col cols="12" md="9" class="pt-0 pt-md-3 order-1 order-md-0 d-flex flex-md-column justify-content-between pr-0 pl-0 pr-md-3">
                <div>
                  <audio-player :src="audio.source" />
                </div>
              </v-col>
              <v-col cols="12" md="3" class="d-flex flex-row align-items-start flex-md-column">
                <div class="fs-12 grey--text pr-sm-2">{{ this.dateFormatWithTimezone(audio.created) }}</div>
                <div class="fs-12 grey--text">{{ audio.username }}</div>
              </v-col>
            </v-row>
          </v-card-text>

        </div>
    </v-card>
</template>

<script>
import dateFormatter from "@/mixin/dateFormatter";

export default {
    name: "OrderAudio",
    mixins: [dateFormatter],
    props: {
      item: {
        type: Object,
        required: true
      },
      removeAudio: {
        type: Function,
        required: true
      },
    },

    data() {
        return {
             audio: this.item
        }
    },

    methods: {
        async archiveAudio(audio) {
            audio.archive = !audio.archive
            await this.removeAudio(audio)
        },
    }
}
</script>

<style scoped>
  @media only screen and (max-width: 474px) {
    /deep/ .ar-player > .ar-player-bar > .ar-player__progress {
      width: calc(100vw - 330px) !important;
      min-width: 40px !important;
    }
  }

  /deep/ .ar-player {
    justify-content: start;
  }

</style>