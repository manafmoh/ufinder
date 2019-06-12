<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="signup"
        >
            <v-text-field
            v-model="form.name"
            label="Name"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.name">{{errors.name[0]}}</span>
            <v-text-field
            v-model="form.email"
            label="Email"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.email">{{errors.email[0]}}</span>
            <v-text-field
            v-model="form.password"
            label="Password"
            type="password"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.password">{{errors.password[0]}}</span>

            <v-text-field
            v-model="form.password_confirmation"
            label="Confirm Password"
            type="password"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.password_confirm">{{errors.password_confirmation[0]}}</span>
            <v-btn
            color="success"
            type="submit"
            >
            Sign Up
            </v-btn>
        </v-form>
        <v-btn color="blue" @click="showLogin" flat>Login</v-btn>
    </v-container>
</template>

<script>
export default {
     data() {
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            errors: {

            }
        }
    },
    created() {
        if(User.loggedIn()) {
            this.$router.push({name: 'ads'});
        }
    },
    methods: {
        signup() {
           //User.signup(this.form);
            axios.post('/api/auth/signup', this.form)
                .then(res => {
                    User.responseAfterLogin(res)
                    this.$router.push({name: 'ads'})
                })
                //.catch(error => console.log(error.response.data));
                .catch(error => this.errors =  error.response.data.errors);
        },
        showLogin() {
            EventBus.$emit('ShowLogin', true);
        }
    }
}
</script>

<style>

</style>
