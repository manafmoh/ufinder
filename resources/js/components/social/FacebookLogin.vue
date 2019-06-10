<template>
  <div >
    <facebook-login class="button"
      appId="2328368750589826"
      @login="onLogin"
      @logout="onLogout"
      @sdk-loaded="sdkLoaded">
    </facebook-login>
  </div>
</template>
<script>
import Vue from 'vue'
import facebookLogin from 'facebook-login-vuejs';


export default {
  components: { facebookLogin},
  data(){
    return{
      idImage:'', loginImage:'', mailImage:'', faceImage:'',
      isConnected: false,
      name: '',
      firstname: '',
      lastname: '',
      email: '',
      personalID: '',
      FB: undefined
    }
  },
  methods: {
  getUserData() {
      this.FB.api('/me', 'GET', { fields: 'id,name,first_name,last_name,email,gender,picture,link' },
        userInformation => {
          //console.warn("data api",userInformation)
          this.personalID = userInformation.id;
          this.name = userInformation.name;
          this.email = userInformation.email;
          this.firstname = userInformation.first_name;
          this.lastname = userInformation.last_name;
          const userInfo= {
              'id':this.personalID,
              'name':this.name,
              'email':this.email,
              'firstname':this.firstname,
              'lastname':this.lastname
          }
          Facebook.login(userInfo);
        }
      )
    },
    sdkLoaded(payload) {
      this.isConnected = payload.isConnected
      this.FB = payload.FB
      if (this.isConnected) this.getUserData()
    },
    onLogin() {
      this.isConnected = true
      this.getUserData();
      if(User.loggedIn()) {
            this.$router.push({name: 'ads'});
        }
    },
    onLogout() {
      this.isConnected = false;
    }
  }
}
</script>

<style>

</style>
