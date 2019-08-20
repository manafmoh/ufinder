import Token from './Token';
import AppStorage from './AppStorage';
class Google {
    login(data){
        axios.post('http://ufindna.com/api/auth/googlelogin', null,{ params: { 'id':data.id , 'name':data.name, 'firstname':data.firstname, 'lastname':data.lastname,'email':data.email} })
           .then(res => this.responseAfterLogin(res))
           .catch(error => {
               console.log(error.response.data);
              // EventBus.$emit('isGoogleLoggin', false);
            });
    }
    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        if(Token.isValidGoogle(access_token)){
            AppStorage.store(access_token, user);
            window.location = "/";
        }
    }

}

export default Google = new Google();
