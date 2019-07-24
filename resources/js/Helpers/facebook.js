import Token from './Token';
import AppStorage from './AppStorage';
class Facebook {
    login(data){
        axios.post('https://ufindna.com/api/auth/facebooklogin', null,{ params: { 'id':data.id , 'name':data.name, 'firstname':data.firstname, 'lastname':data.lastname,'email':data.email} })
           .then(res => this.responseAfterLogin(res))
           .catch(error => {
               console.log(error.response.data);
               EventBus.$emit('isFacebookLoggin', false);
            });
    }
    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        if(Token.isValidFacebook(access_token)){
            AppStorage.store(access_token, user);
            window.location = "/";
        }
    }

}

export default Facebook = new Facebook();
