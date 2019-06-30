import User from "./user"

class Exception {
    handle(error) {
        this.isException(error.response.data.error);
    }
    isException(error) {
        if(error == 'Token is expired') {
            User.loggedOut();
        }
    }
}

export default  Exception = new Exception();
