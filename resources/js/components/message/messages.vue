<template>
  <v-container fluid>
      <h1 v-if="messages">Replies</h1>
        <message v-for="message in contents" :key="message.id" :message="message"></message>
  </v-container>
</template>

<script>
import message from './message';
export default {
    components: {message},
    props:['messages'],
    data() {
        return {
            contents: this.messages,
        }
    },
    created() {
        this.listen();
    },
    methods: {
        listen() {
            EventBus.$on('NewMessage', (message)=>{
                this.contents.unshift(message);
            })
        }
    }

}
</script>

<style>

</style>
