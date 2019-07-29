class AppStorage {
    setToken(token) {
        localStorage.setItem('token', token);
    }
    setUser(user) {
        localStorage.setItem('user', user);
    }
    setEmail(email) {
        localStorage.setItem('email', email);
    }
    store(token, user, email) {
        this.setToken(token);
        this.setUser(user);
        this.setEmail(email);
    }
    clear(){
        localStorage.removeItem('token');
        localStorage.removeItem('user')
    }

    getToken() {
        return localStorage.getItem('token');
    }

    getUser() {
        return localStorage.getItem('user');
    }
    getEmail() {
        return localStorage.getItem('email');
    }


}

export default AppStorage = new AppStorage();
