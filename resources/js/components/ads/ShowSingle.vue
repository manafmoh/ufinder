<template>
<v-layout>

     <v-container fluid>
         <v-card-title primary-title>
          <div>
            <h3 class="headline">
                    {{ad.title}}
                </h3>
                {{ad.uploads}}
            <div class="grey--text">{{ad.user}} Said {{ad.created_at}} </div>
          </div>
          <v-spacer></v-spacer>
          <v-btn color="teal" dark>{{ad.messages_count}} Replies</v-btn>
        </v-card-title>
        <v-card-text v-html="body"></v-card-text>
        <img v-img:group-2="{ cursor: 'zoom-in' }" src="https://picsum.photos/500/300?image=15" width="150px">
        <img v-img:group-2="{ cursor: 'zoom-in' }" src="https://picsum.photos/500/300?image=16" width="150px">


        <v-card-actions v-if="ownad">
            <v-btn icon small @click="edit" >
                <v-icon color="orange">edit</v-icon>
            </v-btn>
            <v-btn icon small @click="destroy" >
                <v-icon color="red">delete</v-icon>
            </v-btn>
        </v-card-actions>
        <Messages :ad="ad"></Messages>
        <NewMessage :adSlug="ad.slug"></NewMessage>
     </v-container>
    </v-layout>
</template>

<script>
import Messages from '../message/messages'
import NewMessage from '../message/newMessage'
export default {
    props:['ad'],
    components: {Messages, NewMessage},
    computed: {
        body() {
            return md.parse(this.ad.body)
        }
    },
    data() {
        return {
            ownad: User.ownAd(this.ad.user_id)
        }
    },
    methods: {
        destroy() {
            axios.delete(`/api/ad/${this.ad.slug}`)
            .then(res => this.$router.push('/ads'))
            .catch(error => console.log(error.response.data))
        },
        edit() {
            EventBus.$emit('startEdit')
        }
    }
}
</script>

<style>

</style>
