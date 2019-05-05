<template>
    <v-container fluid>
    <v-card>
        <v-card-title>
            <div class="headline">{{message.user}}</div>
            <div class="ml-3">said at {{message.created_at}}</div>
            <v-spacer></v-spacer>
            <like-it :content="message"></like-it>
        </v-card-title>
        <v-divider></v-divider>
        <edit-message v-if="editMessage" :message="message"></edit-message>
        <v-card-text v-else v-html="messageBody">
        </v-card-text>
         <v-divider></v-divider>
        <div v-if="!editMessage">
        <v-card-actions v-if="own">
            <v-btn small icon @click="edit">
                <v-icon color="orange">edit</v-icon>
            </v-btn>
            <v-btn small icon @click="destroy(index)">
                <v-icon color="red">delete</v-icon>
            </v-btn>
        </v-card-actions>
        </div>
    </v-card>
    </v-container>
</template>

<script>
import EditMessage from './editMessage';
import LikeIt from '../like/like'
export default {
    components: {EditMessage, LikeIt},
    props: ['message', 'index'],
    data() {
        return {
            editMessage: false,
            messageBeforeEdit: ''
        }
    },
    created() {
        this.listen();
    },
    computed: {
        own() {
            return User.ownAd(this.message.user_id)
        },
        messageBody() {
            return md.parse(this.message.message)
        }
    },
    methods: {
        edit() {
            this.editMessage = true;
            this.messageBeforeEdit = this.message.message;
        },
        destroy(index) {
            EventBus.$emit('DeleteMessage', index)
        },
        listen() {
            EventBus.$on('cancelMessage', (checkmessage)=> {
                //console.log('LOOOOOG ',checkmessage);
                 this.editMessage = false;
                 if(checkmessage != this.message.message) {
                     this.message.message = this.messageBeforeEdit;
                 }
            })
        }
    }
}
</script>

<style>

</style>
