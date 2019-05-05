<template>
    <div>
        <markdown-editor v-model="message.message"></markdown-editor>
         <v-card-actions >
            <v-btn small icon @click="update">
                <v-icon color="green">update</v-icon>
            </v-btn>
            <v-btn small icon @click="cancel">
                <v-icon color="black">cancel</v-icon>
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
export default {
    props: ['message'],
    data() {
        return {

        }
    },
    methods: {
        update(){
            axios.patch(`/api/ad/${this.message.ad_slug}/message/${this.message.id}`, {body:this.message.message})
            .then(res=> {
                this.cancel(this.message.message);
            })
            .catch(error=> console.log(error))
        },
        cancel(message) {
            EventBus.$emit('cancelMessage', message)
        }
    }
}
</script>

<style>

</style>
