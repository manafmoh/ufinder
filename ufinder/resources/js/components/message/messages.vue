<template>
  <v-container fluid>
      <h1 v-if="contents">Replies</h1>
        <message v-for="(message, index) in contents"
        :key="message.id"
        :message="message"
        :index="index"></message>
  </v-container>
</template>

<script>
import message from './message';
export default {
    components: {message},
    props:['ad'],
    data() {
        return {
            contents: this.ad.messages,
        }
    },
    created() {
        this.listen();
    },
    methods: {
        listen() {
            EventBus.$on('NewMessage', (message)=>{
                this.contents.unshift(message);
            });
            EventBus.$on('DeleteMessage', (index)=>{
                axios.delete(`/api/ad/${this.ad.slug}/message/${this.contents[index].id}`)
                .then(res => {
                    this.contents.splice(index, 1);
                })
                .catch(error=> console.log(error))

            });
        }
    }

}
</script>

<style>

</style>
