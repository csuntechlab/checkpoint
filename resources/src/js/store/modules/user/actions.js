

import User from '../../../api/User';
import router from '../../../router';
import _user from '../../mutation-types/User';

export default {
    login({ commit, dispatch }, payload) {
        User.fetchLoginAPI(
            payload,
            (success) => {
                commit(_user.LOGIN_USER, success);
                router.push('admin');
            },
            (error) => console.log(error),
        );
    },
}
