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
            <span class="red--text" v-if="errors.name">{{errors.name[0]}}error</span>
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
            v-model="form.password_confirm"
            label="Confirm Password"
            type="password"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.password_confirm">{{errors.password_confirm[0]}}</span>
            <v-btn
            color="success"
            type="submit"
            >
            Sign Up
            </v-btn>
            <router-link to="login">
                <v-btn color="blue" flat>Login</v-btn>
            </router-link>
        </v-form>
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
                password_confirm: null,
            },
            errors: {

            }
        }
    },
    methods: {
        signup() {
           //User.signup(this.form);
            axios.post('/api/auth/signup', this.form)
                .then(res => User.responseAfterLogin(res))
                //.catch(error => console.log(error.response.data));
                .catch(error => this.errors =  error.response.data.errors);

        }
    }
}
</script>

<style>

</style>
