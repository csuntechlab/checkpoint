import axios from 'axios';


const fetchStudentsAPI = (success, error) => {
    axios.get('api/students').then(
        response => success(response.data),
        response => error(response),
    );
};

export default {
    fetchStudentsAPI
}
