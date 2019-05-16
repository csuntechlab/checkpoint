import axios from 'axios';

const fetchOrgSettingsAPI = (payload, success, error) => {
    axios.post('/api/orgSettings', payload).then(
        response => success(response.data),
        response => error(response),
    );
};

export default {
    fetchOrgSettingsAPI
}
