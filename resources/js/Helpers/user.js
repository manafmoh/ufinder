import Token from './Token';
import AppStorage from './AppStorage';
class User {
    login(data){
        axios.post('/api/auth/login', data)
           .then(res => this.responseAfterLogin(res))
           .catch(error => console.log(error.response.data));
    }

    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        if(Token.isValid(access_token)){
            AppStorage.store(access_token, user);
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        return Token.isValid(storedToken) ? true: false
        return false
    }

    loggedIn() {
        return this.hasToken();
    }

    loggedOut() {
        AppStorage.clear();
    }

    name() {
        if(this.hasToken()) {
            return AppStorage.getUser();
        }
    }

    id() {
        if(this.hasToken()) {
            const payload = Token.getPayload(AppStorage.getToken());
            return payload.sub;
        }
        return null
    }
}

export default User = new User();
