import Token from './Token';
import AppStorage from './AppStorage';
class Google {
    login(data){ console.log(data);
        axios.post('/api/auth/googlelogin', data)
           .then(res => this.responseAfterLogin(res))
           .catch(error => {
               console.log(error.response.data);
              // EventBus.$emit('isGoogleLoggin', false);
            });
    }
    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        console.log('AF', user);
        if(Token.isValidGoogle(access_token)){
            AppStorage.store(access_token, user);
            window.location = "/";
        }
    }

}

export default Google = new Google();
