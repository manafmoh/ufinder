import Token from './Token';
import AppStorage from './AppStorage';
import swal from 'sweetalert';
class Facebook {
    login(data){
        //https://ufindna.com - i removed, pls add and check
        axios.post('/api/auth/facebooklogin', null,{ params: { 'id':data.id , 'name':data.name, 'firstname':data.firstname, 'lastname':data.lastname,'email':data.email} })
           .then(res => this.responseAfterLogin(res))
           .catch(error => {
               //console.log(error.response.data);
               swal('Sorry!!', error.response.data, "error");
               EventBus.$emit('isFacebookLoggin', false);
            });
    }
    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        if(Token.isValidFacebook(access_token)){
            AppStorage.store(access_token, user);
            window.location = "/post";
        }
    }

}

export default Facebook = new Facebook();
