<template>
  <v-tooltip left color="primary">
    <template v-slot:activator="{ on, attrs }">
      <v-btn
          color="primary"
          class="white--text"
          fab
          small
          @click="$emit('funcClose')"
          v-bind="attrs"
          v-on="on"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </template>
    <span>{{ title }}</span>
  </v-tooltip>
</template>

<script>
export default {
  name: 'AddRecordButton',
  props: {
    title: {
      type: String,
      required: true
    }
  }
}
</script>