<template>
    <v-container>
        <v-form v-if="loginFlag"
            ref="form"
            @submit.prevent="login"
        >
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
            <v-btn
            color="success"
            type="submit"
            >
            Login
            </v-btn>

            <v-btn
            color="success"
            @click="showSignUp"
            >
            Sign Up
            </v-btn>
        </v-form>
        <Signup v-if="signupFlag" />
    </v-container>
</template>

<script>
import Signup from './Signup';
export default {
    components: { Signup},
    data() {
        return {
            form: {
                email: null,
                password: null
            },
            loginFlag: true,
            signupFlag:false
        }
    },
    created() {
        this.listen();
        if(User.loggedIn()) {
            this.$router.push({name: 'ads'});
        }
    },
    methods: {
        login() {
           User.login(this.form);
           this.$router.push({name: 'ads'});
        },
        showSignUp() {
            this.signupFlag = true;
            this.loginFlag = false;
        },
        showLogin() {
            this.signupFlag = false;
            this.loginFlag = true;
        },
        listen() {
            EventBus.$on('ShowLogin', ()=> {
                this.showLogin();
            })
        }

    }
}
</script>

<style>

</style>
