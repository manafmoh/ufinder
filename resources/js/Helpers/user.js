import Token from './Token';
import AppStorage from './AppStorage';
import swal from 'sweetalert';
class User {
    login(data){
        axios.post('/api/auth/login', data)
           .then(res => this.responseAfterLogin(res))
           .catch(error => {
               //console.log(error.response.data.error)
               swal(error.response.data.error, "The email address or password you entered is not valid. Please try again.", "error");
            });
    }

    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        const email = res.data.email;
        if(Token.isValid(access_token)){
            AppStorage.store(access_token, user, email);
            window.location = "/post";
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
    email() {
        if(this.hasToken()) {
            return AppStorage.getEmail();
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
