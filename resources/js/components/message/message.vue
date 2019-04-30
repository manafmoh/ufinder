<template>
    <v-container fluid>
    <v-card>
        <v-card-title>
            <div class="headline">{{message.user}}</div>
            <div class="ml-3">said at {{message.created_at}}</div>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text v-html="message.message">
        </v-card-text>
         <v-divider></v-divider>
        <v-card-actions v-if="own">
            <v-btn small icon @click="edit">
                <v-icon color="orange">edit</v-icon>
            </v-btn>
            <v-btn small icon @click="destroy">
                <v-icon color="red">delete</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
    </v-container>
</template>

<script>
export default {
    props: ['message'],
    computed: {
        own() {
            return User.ownAd(this.message.user_id)
        }
    },
    methods: {
        edit() {

        },
        destroy() {

        }
    }
}
</script>

<style>

</style>
