<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="createAd"
        >
            <v-text-field
            v-model="form.title"
            label="Title"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.title">{{errors.title[0]}}</span>

            <v-select
            :items="categories"

            v-model="form.category_id"
            item-text="name"
            item-value="id"
            label="Category"
            autocomplete
            ></v-select>

            <markdown-editor v-model="form.body"></markdown-editor>

            <v-btn
            color="success"
            type="submit"
            >
            Create
            </v-btn>
        </v-form>
    </v-container>
</template>

<script>
export default {
    data(){
        return {
            form: {
                title: null,
                category_id: null,
                body: null,
                amount: 0,
                featured: 0,
                user_id: 2
            },
            categories: {},
            errors: {}
        }

    },
    methods: {
        createAd() {
            axios.post('/api/ad', this.form)
            .then( res => {
                //Redirecting the url
                this.$router.push(res.data.path)
            })
            .catch(error => console.log(error.response.data.error));
        }
    },
    created() {
            axios.get('/api/category')
            .then( res => this.categories = res.data.data)
            .catch(error => console.log(error.data.error));
        }
}
</script>

<style>

</style>
