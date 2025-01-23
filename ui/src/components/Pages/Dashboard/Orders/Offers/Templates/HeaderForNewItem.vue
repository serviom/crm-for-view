<template>
  <div class="d-flex align-items-center justify-content-between pt-4 px-5">
    <v-card-title class="pt-0 pl-0">{{ title }}</v-card-title>
    <v-btn
        color="grey"
        text
        icon
        @click="$emit('funcClose')"
        style="margin-top:-15px; margin-right:-5px;"
    >
      <v-icon>mdi-close</v-icon>
    </v-btn>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    }
  }
}
</script>