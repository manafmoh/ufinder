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
            window.location = "/";
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return Token.isValid(storedToken) ? true : this.logout()
        }
        return false
    }

    loggedIn() {
        return this.hasToken();
    }

    loggedOut() {
        AppStorage.clear();
        window.location = "/";
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
    ownAd(id) {
        return this.id() == id? true: false;
    }

    isAdmin(id) {
        // id of Admin
        return this.id() == 1? true: false;
    }
}

export default User = new User();
