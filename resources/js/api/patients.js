import axios from 'axios';

export default {
    all(url) {
        return axios.get(`/api/patients/${url}`);
    },
    find(id) {
        return axios.get(`/api/patients/${id}`);
    },
    update(id, data) {
        return axios.put(`/api/patients/${id}`, data);
    },
};