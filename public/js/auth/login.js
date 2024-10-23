import { $SingleFormPostController } from '../common/core/controllers.js';
import { ENDPOINT, __API_CFG__ } from "../common/base/config/config.js";

const loginConfig = {
    formSelector: '#login-form',
    buttonSelector: '#login-form button[type="submit"]',
    feedback: true,
    endpoint: `${__API_CFG__.BASE_URL}${ENDPOINT.AUTHENTICATION.LOGIN}`,
    onSuccess: (res) => {
        window.location.href = res.redirect;
    },
}

const login = new $SingleFormPostController(loginConfig)
login.init();