import Token from './Token';
import AppStorage from './AppStorage';
import swal from 'sweetalert';
class Google {
    login(data){
        axios.post('/api/auth/googlelogin',null, { params: { 'id':data.id , 'name':data.name, 'firstname':data.firstname, 'lastname':data.lastname,'email':data.email} })
           .then(res => this.responseAfterLogin(res))
           .catch(error => {
               //console.log(error.response.data);
               swal('Sorry!!', error.response.data, "error");
              // EventBus.$emit('isGoogleLoggin', false);
            });
    }
    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        //console.log('AF', user);
        if(Token.isValidGoogle(access_token)){
            AppStorage.store(access_token, user);
            window.location = "/post";
        }
    }

}

export default Google = new Google();
