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

            <v-text-field
            v-model="form.email"
            label="Email"
            required
            ></v-text-field>

            <v-text-field
            v-model="form.password"
            label="Password"
            type="password"
            required
            ></v-text-field>

            <v-text-field
            v-model="form.password_confirm"
            label="Confirm Password"
            type="password"
            required
            ></v-text-field>
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
            }
        }
    },
    methods: {
        signup() {
           User.signup(this.form);
        }
    }
}
</script>

<style>

</style>
