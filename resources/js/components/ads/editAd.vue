<template>
<v-container>
    <v-form
        ref="form"
        @submit.prevent="updateAd"
    >
        <v-text-field
        v-model="form.title"
        label="Title"
        required
        ></v-text-field>
        <span class="red--text" v-if="errors.title">{{errors.title[0]}}</span>

        <markdown-editor v-model="form.body"></markdown-editor>

        <v-card-actions >
            <v-btn icon small type="submit" >
                <v-icon color="green">save</v-icon>
            </v-btn>
            <v-btn icon small @click="cancel" >
                <v-icon color="black">cancel</v-icon>
            </v-btn>
        </v-card-actions>
    </v-form>
    </v-container>
</template>

<script>
export default {
    props: ['ad'],
    data(){
        return {
            form: {
                title: null,
                body: null
            },
            errors: {}
        }
    },
    methods: {
        updateAd() {
            axios.patch(`/api/ad/${this.ad.slug}`, this.form)
            .then(res => this.cancel())
            .catch(error => error.response.data);
        },
        cancel() {
            EventBus.$emit('cancelEditing');
        }
    },
    mounted() {
        this.form = this.ad;
    }


}
</script>

<style>

</style>
