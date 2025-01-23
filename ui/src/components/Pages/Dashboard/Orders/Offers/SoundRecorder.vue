<template>
  <div>
    <audio-recorder
        upload-url=""
        :attempts="1"
        :time="30"
        :before-recording="handleBeforeRecording"
        :pause-recording="handlePauseRecording"
        :after-recording="handleAfterRecording"
        :before-upload="handleBeforeUpload"
        :successful-upload="handleSuccessfulUpload"
        :failed-upload="handleFailedUpload"
        :show-upload-button="false"
        :select-record="handleSelectRecord"
    />
  </div>
</template>

<script>

export default {
  name: "SoundRecorder",
  props: {},
  data() {
    return {
      timer: null
    };
  },
  mounted() {
    this.eventHub.$on("resetSoundRecorder", () => {
      const removeElement = this.$el.querySelector('.ar__rm');
      if (removeElement) {
        removeElement.click();
      }
    });
  },
  beforeDestroy() {
    this.handleRemoveDestroy();
    clearTimeout(this.timer);
    this.eventHub.$off("resetSoundRecorder");
  },
  methods: {
    handleRemoveDestroy() {
      const removeElement = this.$el.querySelector('.ar__rm');
      if (removeElement) {
        removeElement.removeEventListener('click', this.handleRemoveClick);
      }
    },
    handleBeforeRecording() {
      console.log('Recording started');
    },
    handlePauseRecording() {
      console.log('Recording started');
    },
    handleAfterRecording(data) {
      this.$nextTick(() => {
        const recordElement = this.$el.querySelector('.ar-records__record');
        if (recordElement) {
          recordElement.click();
          this.$emit('sound-recorded', data.url);
        } else {
          console.debug('Element with class "ar-records__record" not found.');
        }
      });
    },
    handleRemoveClick() {
      this.$emit('sound-recorded', '');
      this.handleRemoveDestroy();
    },
    handleSelectRecord(data) {
      console.log('Select record', data);
      this.timer = setTimeout(() => {
        const removeElement = this.$el.querySelector('.ar__rm');
        removeElement.addEventListener('click', this.handleRemoveClick);
      }, 500);
    },
    handleBeforeUpload() {
      console.log('Uploading file...');
    },
    handleSuccessfulUpload() {
      console.log('Upload successful!');
    },
    handleFailedUpload() {
      console.log('Upload failed');
    },

  }
};
</script>

<style scoped>
  h3 {
    margin: 40px 0 0;
  }

  /deep/ .ar-records {
    height: auto !important;
    padding-top: 15px;
    margin-bottom: 10px !important;
  }

  /deep/ .ar-records__record {
    width: 322px!important;
    min-width: 222px!important;
  }

  /deep/ .ar-player-actions {
    width: auto!important;
  }

  /deep/ .ar-recorder__duration {
    margin-top: 30px;
  }

  /deep/ .ar-recorder__records-limit {
    top: 76px !important;
  }

  /deep/ .ar {
    box-shadow: none;
  }

  /deep/ .ar-records__record--selected {
    margin-top: 20px;
  }

  @media only screen and (max-width: 628px) {
    /deep/ .ar {
      width: 400px;
    }
  }

  @media only screen and (max-width: 474px) {
    /deep/ .ar-player > .ar-player-bar > .ar-player__progress {
      width: calc(100vw - 370px) !important;
      min-width: 40px!important;
    }

    /deep/ .ar-records__record {
      width: calc(100vw - 160px) !important;
    }

    /deep/ .ar {
      width: calc(100vw - 70px);
    }
  }

</style>
