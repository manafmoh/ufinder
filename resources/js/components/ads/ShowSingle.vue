<template>
<v-layout>

     <v-container fluid>
         <v-card-title primary-title>
          <div>
            <h3 class="headline">
                    {{ad.title}}
                </h3>
            <div class="grey--text">{{ad.user}} Said {{ad.created_at}} </div>
          </div>
          <v-spacer></v-spacer>
          <div class="right-side">
          <v-btn flat icon color="blue lighten-2" style="display:block">
            <v-icon>phone</v-icon> {{ad.mobile}}
             </v-btn>
          <v-btn color="teal" dark>{{ad.messages_count}} Replies</v-btn>
          </div>
        </v-card-title>
        <v-card-text v-html="body"></v-card-text>

        <ImageGallery  :ad="ad"></ImageGallery>

        <v-card-actions v-if="ownad">
            <v-btn icon small @click="edit" >
                <v-icon color="orange">edit</v-icon>
            </v-btn>
            <v-btn icon small @click="destroy" >
                <v-icon color="red">delete</v-icon>
            </v-btn>
        </v-card-actions>
        <div v-if="isLoggedIn">
        <Messages :ad="ad"></Messages>
        <NewMessage :adSlug="ad.slug"></NewMessage>
        </div>
        <div v-else class="title red--text">
            Login to Message <LoginPopup />
        </div>
     </v-container>
    </v-layout>
</template>

<script>
import Messages from '../message/messages'
import NewMessage from '../message/newMessage'
import ImageGallery from './ImageGallery'
import LoginPopup from '../LoginPopup';
export default {
    props:['ad'],
    components: {Messages, NewMessage, ImageGallery, LoginPopup},
    computed: {
        body() {
            return md.parse(this.ad.body)
        }
    },
    data() {
        return {
            ownad: User.ownAd(this.ad.user_id),
            isLoggedIn: User.loggedIn()
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
