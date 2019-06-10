class Token {
    getPayload(data) {
        const payload  = data.split('.')[1];
        return JSON.parse(this.decode(payload));;
    }

    decode(payload) {
        return atob(payload);
    }

    isValid(data) {
        const payload = this.getPayload(data);
        if(payload) {
            return payload.iss == "http://127.0.0.1:8000/api/auth/login"
            || "http://127.0.0.1:8000/api/auth/signup" ? true: false;
        }
        return false;
    }
    isValidFacebook(data) {
        const payload = this.getPayload(data);
        if(payload) {
            return payload.iss == "http://localhost:8000/api/auth/facebooklogin"
             ? true: false;
        }
        return false;
    }

}

export default Token = new Token();
