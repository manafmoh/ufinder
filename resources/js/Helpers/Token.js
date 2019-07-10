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
            return payload.iss == "'"+process.env.MIX_APP_URL+"/api/auth/login'"
            || "'"+process.env.MIX_APP_URL+"/api/auth/signup'" ? true: false;
        }
        return false;
    }
    isValidFacebook(data) { alert("'"+process.env.MIX_APP_URL+"/api/auth/login'");
        const payload = this.getPayload(data);
        if(payload) {
            return payload.iss == "'"+process.env.MIX_APP_URL+"/api/auth/facebooklogin'"
             ? true: false;
        }
        return false;
    }

}

export default Token = new Token();
