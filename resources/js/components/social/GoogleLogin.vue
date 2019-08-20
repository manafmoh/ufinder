<template>
<div>
  <g-signin-button
    class="loginBtn loginBtn--google"
    :params="googleSignInParams"
    @success="onSignInSuccess"
    @error="onSignInError">
    Sign in with Google
  </g-signin-button>
</div>
</template>
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
import Token from '../../Helpers/Token'
import AppStorage from '../../Helpers/AppStorage';
export default {
    created() {
      //this.listen();
  },
  data () {
    return {
      /**
       * The Auth2 parameters, as seen on
       * https://developers.google.com/identity/sign-in/web/reference#gapiauth2initparams.
       * As the very least, a valid client_id must present.
       * @type {Object}
       */
      googleSignInParams: {
        client_id: '551719641555-fmr9poub2tr84lp0qelv8ne3rmvqboc9.apps.googleusercontent.com'
      },
      isConnected: false,
      name: '',
      firstname: '',
      lastname: '',
      email: '',
      personalID: '',
    }
  },
  methods: {
    onSignInSuccess (googleUser) {
      // `googleUser` is the GoogleUser object that represents the just-signed-in user.
      // See https://developers.google.com/identity/sign-in/web/reference#users
      const userInformation = googleUser.getBasicProfile() // etc etc
        this.personalID = userInformation.getId();
        this.name = userInformation.getName();
        this.email = userInformation.getEmail();
        this.firstname = userInformation.getGivenName();
        this.lastname = userInformation.getFamilyName();
        const userInfo= {
            'id':this.personalID,
            'name':this.name,
            'email':this.email,
            'firstname':this.firstname,
            'lastname':this.lastname
        }
        const userInfo= {
            'id':13123,
            'name':'Masnaf',
            'email':'manafmoh@gmail.com',
            'firstname':'Mohd Manaf',
            'lastname':'Manaf'
        }
         axios.post('/api/auth/googlelogin',{ params: { 'id':userInfo.id , 'name':userInfo.name, 'firstname':userInfo.firstname, 'lastname':userInfo.lastname,'email':userInfo.email} })
           .then(res => this.responseAfterLogin(res))
           .catch(error => {
               console.log(error.response.data);
              // EventBus.$emit('isGoogleLoggin', false);
            });

    },
    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        console.log('AF', user);
        if(Token.isValidGoogle(access_token)){
            AppStorage.store(access_token, user);
            window.location = "/";
        }
    },
    onSignInError (error) {
      // `error` contains any error occurred.
      console.log('OH NOES', error)
    },
    listen() {
        EventBus.$on('FacebookContinue', ()=> {
            this.isConnected = true
            this.onLogin();
            EventBus.$emit('CloseDialog');
        });
      }
  }
}
</script>

<style>
.g-signin-button {
  /* This is where you control how the button looks. Be creative! */
  display: inline-block;
  padding: 4px 8px;
  border-radius: 3px;
  background-color: #3c82f7;
  color: #fff;
  box-shadow: 0 3px 0 #0f69ff;
}
</style>
