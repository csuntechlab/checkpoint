import axios from 'axios';

const fetchMentorsAPI = (payload, success, error) => {
    axios.post('/api/mentors', payload).then(
        response => success(response.data),
        response => error(response),
    );
};

export default {
    fetchMentorsAPI
}
