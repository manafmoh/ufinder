<template>
    <div>
        <markdown-editor v-model="form.body"></markdown-editor>
        <v-btn
            color="success"
            @click="submit">
            Reply
        </v-btn>
    </div>

</template>

<script>
export default {
    data() {
        return{
            form: {
                body: null
            }
        }
    },
    props: ['adSlug'],
    methods: {
        submit() {
            axios.post(`/api/ad/${this.adSlug}/message`, this.form)
            .then(res=> {
                this.form.body = '';
                EventBus.$emit('NewMessage', res.data.message);
                window.scrollTo(0,0);
            })
            .catch(error => console.log(error))
        }
    }
}
</script>

<style>

</style>
