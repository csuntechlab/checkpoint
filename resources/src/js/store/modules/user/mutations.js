
import _user from '../../mutation-types/User';


export default {
    [_user.LOGIN_USER](state, payload) {
       state.session = payload;
       state.sessionActive = true;
    },
    [_user.LOGOUT_USER](state) {
        state.session = Object.assign({});
        state.sessionActive = false;
    },
}
