<template>
  <v-container fluid>
      <h1 v-if="messages">Replies</h1>
      <message v-for="message in messages" :key="message.id" :message="message"></message>
  </v-container>
</template>

<script>
import message from './message';
export default {
    components: {message},
    props:['messages'],
    data() {
        return {}
    }
}
</script>

<style>

</style>
