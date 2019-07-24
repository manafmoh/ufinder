<template>
    <v-btn v-if="isLogin" flat class="indigo lighten-2" href="/logout">Logout</v-btn>
    <v-dialog v-else max-width="600px" v-model="dialog" >
        <v-btn  flat slot="activator" class="success">Login</v-btn>
        <v-card  v-if="fbLogin">
            <v-card-title>
                <facebook-login v-if="!isFacebookLogin"></facebook-login>
                <v-btn v-else @click="redirect" class="success">Login with facebook</v-btn>
            </v-card-title>
            <v-card-title>
                <GoogleLogin></GoogleLogin>
            </v-card-title>
        </v-card>
        <v-card  >
            <v-card-title>
                <v-btn @click="showEmailLogin" class="success">Login with email</v-btn>
                <EmailLogin v-if="emailLogin"/>
            </v-card-title>
        </v-card>
    <v-btn @click="dclose" >Close</v-btn>
    </v-dialog>
</template>
<script>
import FacebookLogin from './social/FacebookLogin';
import GoogleLogin from './social/GoogleLogin'
import EmailLogin from './login/Login';
export default {
    components: {FacebookLogin, EmailLogin, GoogleLogin},
    created() {
        if(User.loggedIn()) {
            this.isLogin= true;
        }
        this.listen();
    },
    data() {
        return {
           dialog: false,
           isLogin: false,
           isFacebookLogin: false,
           isGoogleLogin: false,
           emailLogin:false,
           fbLogin: true,
        }
    },
   /* watch: {
        dialog (val) {
            !val && alert('Dialog is closing')
        }

    },*/
    methods: {
        dclose(){
            this.dialog= false;
            //this.isLogin = true;
           // window.location = "/";
           //refresh window
            //this.$router.push({name: 'ads'});
            //this.$router.go(this.$router.currentRoute);
        },
        listen() {
            EventBus.$on('CloseDialog', ()=> {
                this.dclose();
            }),
            EventBus.$on('isFacebookLoggin', (status)=> {
                this.isFacebookLogin = status;
            });
        },
        redirect() {
             EventBus.$emit('FacebookContinue');
        },
        showEmailLogin() {
            this.emailLogin=true;
            this.fbLogin=false;
        }
    }
}
</script>

<style>

</style>
