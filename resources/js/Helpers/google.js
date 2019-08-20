import Token from './Token';
import AppStorage from './AppStorage';
class Google {
    login(data){ console.log('DATA: ',data);

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
