import axios from 'axios';

const fetchLoginAPI = (payload, success, error) => {
    axios.post('api/login', payload).then(
        response => success(response.data),
        response => error(response),
    );
};

export default {
    fetchLoginAPI
}
