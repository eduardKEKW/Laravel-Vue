import axios from 'axios';

const BASE_URL_AUTH = '/api/auth';
const BASE_URL = '/api';

export default {
    register({ data, method }) {
        return axios[method](`${BASE_URL_AUTH}/register`, data);
    },
    login({ data, method }) {
        return axios[method](`${BASE_URL_AUTH}/signin`, data);
    },
    getMe({ method = "get", data }) {
        const token = localStorage.getItem("token");

        if (token) {
            axios.defaults.headers.common = {
                Authorization: `Bearer ${token}`
            };

            return axios[method](`${BASE_URL_AUTH}/me`);
        }

        return Promise.resolve(null);
    },
    select({ method, _id }) {
        return axios[method](`${BASE_URL}/questions/${_id}/vote`);
    },
    getQuestions({ method }) {
        return axios[method](`${BASE_URL}/questions`);
    },
    getQuestion({ method = "get", _id }) {
        this.getToken();
        return axios[method](`/api/questions/single/${_id}`);
    },
    vote({ _id, method = "post" }) {
        this.getToken();
        return axios[method](`${BASE_URL}/options/${_id}/vote`);
    },
    deleteQuestion({ _id, method = 'post' }) {
        this.getToken();
        return axios[method](`${BASE_URL}/questions/destroy/${_id}`);
    },
    create({ data, method = "post" }) {
        this.getToken();
        return axios[method](`${BASE_URL}/questions/create`, data);
    },
    saveToken(token) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        localStorage.setItem("token", token);
    },
    getToken() {
        return (axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${localStorage.getItem("token")}`);
    }
};
