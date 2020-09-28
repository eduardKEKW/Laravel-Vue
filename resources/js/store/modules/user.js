import axios from "axios";

const BASE_URL = "/api/auth";

const state = {
    user: null,
    loggedIn: false,
    errors: []
};

const getters = {
    user:       state => state.user,
    loggedIn:   state => state.loggedIn,
    errors:     state => state.errors
};

const actions = {
    register({ commit }, data) {
        axios
            .post(`${BASE_URL}/register`, data)
            .then(response => {
                commit("logInUser", response.data);
            })
            .catch(error => {
                commit("error", error);
            });

    },

    login({ commit }, data) {
        axios
            .post(`${BASE_URL}/signin`, data)
            .then(response => {
                commit("logInUser", response.data);
            })
            .catch(error => {
                commit("error", error);
            });
    },
    getMe({ commit }) {
        const token = localStorage.getItem("token");

        if (token) {
            axios.defaults.headers.common = {
                Authorization: `Bearer ${token}`
            };

            axios
                .get(`${BASE_URL}/me`)
                .then(response => {
                    commit("logInUser", response.data);
                })
                .catch(error => {
                    commit("error", error);
                });
        }
    }
};

const mutations = {
    logInUser: (state, { user, token }) => {
        state.user = user;
        state.loggedIn = true;
        state.errors = [];
        saveToken(token);
    },
    error: (state, error) => {
        console.log(error);
    }
};

const saveToken = (token) => {
    axios.defaults.headers.common = { Authorization: `Bearer ${token}` };
    localStorage.setItem("token", token);
}

export default {
    state,
    getters,
    actions,
    mutations
};
