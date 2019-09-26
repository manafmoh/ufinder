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
            <a @click="doForgotPass" class="black--text">Forgot Password?</a>
        </v-form>
        <Signup v-if="signupFlag" />
        <Forgotpass v-if="showForgotPass" />
    </v-container>
</template>

<script>
import Signup from './Signup';
import Forgotpass from './Forgotpass';
export default {
    components: { Signup, Forgotpass},
    data() {
        return {
            form: {
                email: null,
                password: null
            },
            loginFlag: true,
            signupFlag:false,
            showForgotPass:false
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
            this.showForgotPass = false;
        },
        showLogin() {
            this.signupFlag = false;
            this.loginFlag = true;
            this.showForgotPass = false;
        },
        doForgotPass() {
            this.showForgotPass = true;
            this.signupFlag = false;
            this.loginFlag = false;
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
