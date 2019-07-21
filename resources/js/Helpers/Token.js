class Token {
    //process.env.MIX_APP_URL
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
            return payload.iss == LiveURL+"/api/auth/login"
            || LiveURL+"/api/auth/signup" ? true: false;
        }
        return false;
    }
    isValidFacebook(data) {
        const payload = this.getPayload(data);
        if(payload) {
            console.log(payload);
            console.log(LiveURL+"/api/auth/facebooklogin");
            //return payload.iss == "http://localhost:8000/api/auth/facebooklogin"
            return payload.iss == LiveURL+"/api/auth/facebooklogin"
             ? true: false;
        }
        return false;
    }

}

export default Token = new Token();
