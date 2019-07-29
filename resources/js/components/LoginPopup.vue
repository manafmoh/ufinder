<template>
     <v-menu v-if="isLogin" :nudge-width="200"
      offset-x>
        <v-btn  flat text icon color="primary" slot="activator"><v-icon dark center>account_circle</v-icon></v-btn>
        <v-card>
        <v-list>
          <v-list-tile avatar>
            <v-list-tile-avatar>
              <img src="/userimg.png" :alt="userName">
            </v-list-tile-avatar>

            <v-list-tile-content>
              <v-list-tile-title>{{userName}}</v-list-tile-title>
              <v-list-tile-sub-title>{{userEmail}}</v-list-tile-sub-title>
            </v-list-tile-content>

            <v-list-tile-action>
              <v-btn
                :class="fav ? 'red--text' : ''"
                icon
                @click="fav = !fav"
              >
                <v-icon>favorite</v-icon>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>
        </v-list>

        <v-divider></v-divider>

        <v-list>
          <v-list-tile>
            <v-list-tile-action>
              <v-switch v-model="message" color="purple"></v-switch>
            </v-list-tile-action>
            <v-list-tile-title>Enable messages</v-list-tile-title>
          </v-list-tile>

          <v-list-tile>
            <v-list-tile-action>
              <v-switch v-model="hints" color="purple"></v-switch>
            </v-list-tile-action>
            <v-list-tile-title>Enable hints</v-list-tile-title>
          </v-list-tile>
        </v-list>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn  flat href="/logout">Logout</v-btn>
          <!-- <v-btn color="primary" flat @click="menu = false">Save</v-btn> -->
        </v-card-actions>
      </v-card>
      </v-menu>
    <v-dialog v-else max-width="600px" v-model="dialog" >
        <v-btn  flat slot="activator" class="success">Login</v-btn>
        <v-toolbar dark color="primary">
          <v-toolbar-title>Login</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark flat @click="dclose"> <v-icon>close</v-icon></v-btn>
          </v-toolbar-items>
        </v-toolbar>
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
                <v-btn style="width:210px" @click="showEmailLogin" class="success">Login with email</v-btn>
                <EmailLogin v-if="emailLogin"/>
            </v-card-title>
        </v-card>
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
            this.userName = User.name();
            this.userEmail = User.email();
        }
        this.listen();
    },
    data() {
        return {
        fav: true,
        menu: false,
        message: false,
        hints: true,
           dialog: false,
           isLogin: false,
           isFacebookLogin: false,
           isGoogleLogin: false,
           emailLogin:false,
           fbLogin: true,
           userName:'',
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
