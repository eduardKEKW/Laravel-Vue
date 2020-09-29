import requests from "../../requests";
import { router } from '../../app';

const state = {
    user: null,
    loggedIn: false,
    errors: [],
    showResults: true,
    voted: -1,
    total: 0,
    questions: [],
    loadingSignIn: false,
};

const getters = {
    user: state             => state.user,
    loggedIn: state         => state.loggedIn,
    errors: state           => state.errors,
    loadingSignIn: state    => state.loadingSignIn,
    showResults: state      => state.showResults,
    voted: state            => state.voted,
    total: state            => state.total,
    questions: state        => state.questions
};

const actions = {
    register({ commit }, data) {
        commit("loadingSignIn", true);

        requests.register({ method: 'post', data: data })
            .then(response => {
                commit("logInUser", response.data);
            })
            .catch(error => {
                commit("error", error);
            })
            .finally(() => {
                commit("loadingSignIn", false);
            });
    },

    login({ commit }, data) {
        commit("loadingSignIn", true);

        requests.login({ method: 'post', data })
            .then(response => {
                commit("logInUser", response.data);
            })
            .catch(error => {
                commit("error", error);
            })
            .finally(() => {
                commit("loadingSignIn", false);
            });
    },

    getMe({ commit }) {
        requests.getMe({ method: 'get' })
            .then(response => {
                commit("logInUser", response.data);
            })
            .catch(error => {
                commit("error", error);
            })
            .finally(() => {
                commit("loadingSignIn", false);
            });
    },

    select({ commit }, _id) {
        commit("loading", _id);

        requests.select({ method: 'post', _id })
            .then(response => {
                commit("onSelect", _id);
            })
            .catch(error => {
                console.error(error);
            });
    },

    getQuestions({ commit }) {

        return requests
            .getQuestions({ method: "get" })
            .then(response => {
                commit("getQuestion", response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }
};

const mutations = {
    logInUser: (state, { user, token }) => {
        state.user = user;
        state.loggedIn = true;
        state.errors = [];
        if (token) {
            saveToken(token);
        }
        router.push("home");
    },
    error: (state, error) => {
        console.log(error);
    },
    onSelect(state, _id) {
        state.showResults = true;
        state.loading = -1;
        state.voted = _id;
    },
    loading(state, _id) {
        state.loading = _id;
    },
    getQuestion(state, data) {
        console.log(data);
        state.loading = false;
        state.questions = data;
    },
    loadingSignIn(state, value) {
        state.loadingSignIn = value;
    }
};

const saveToken = (token) => {
    return requests.saveToken(token);
    window.axios.defaults.headers.common = { Authorization: `Bearer ${token}` };
    localStorage.setItem("token", token);
}

export default {
    state,
    getters,
    actions,
    mutations
};
