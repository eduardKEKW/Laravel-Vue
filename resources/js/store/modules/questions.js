import axios from "axios";
import requests from '../../requests';

const state = {
    loading: true,
    loadingVote: false,
    question: null,
    total: 0,
    userVote: null
};

const getters = {
    question: state     => state.question,
    loading: state      => state.loading,
    total: state        => state.total,
    loadingVote: state  => state.loadingVote,
    userVotedOn: state  => state.userVote
};

const actions = {
    select({ commit }, _id) {
        commit("loading", _id);

        axios
            .post(`/api/questions/${_id}/vote`)
            .then(response => {
                commit("onSelect", _id);
            })
            .catch(error => {
                console.error(error);
            });
    },
    getQuestion({ commit }, _id) {
        commit("loading", true);

        requests.getQuestion({ _id })
            .then(response => {
                console.log(response.data);
                commit("setQuestion", response.data);
            })
            .catch(error => {
                console.error(error);
            })
            .finally(() => {
                commit('loading', false);
            });
    },
    vote ({ commit }, _id) {
        commit("loadingVote", _id);

        requests
            .vote({ _id })
            .then(response => {
                console.log(response.data);
                commit('vote', response.data.vote.option_id);
            })
            .catch(error => {
                console.error(error);
            })
            .finally(() => {
                commit("loadingVote", false);
            });
    },
};

const mutations = {
    onSelect(state, _id) {
        state.loading = -1;
        state.voted = _id;
    },
    loading(state, value) {
        state.loading = value;
    },
    loadingVote(state, value) {
        state.loadingVote = value;
    },
    setQuestion(state, { question, user_vote_on }) {
        state.total = question.options.reduce(
            (acc, curr) => acc + curr.votes_count,
            0
        );
        state.question = question;
        state.loading = false;
        state.userVote = user_vote_on[0].option_id;
    },
    vote (state, optionId) {
        if (!state.userVote) {
            state.total += 1;
        }

        const prevOpt = state.question.options.find(q => q.id === state.userVote);
        const newvOpt = state.question.options.find(q => q.id === optionId);

        prevOpt.votes_count -= 1;
        newvOpt.votes_count += 1;

        state.userVote = optionId;
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
    namespaced: true
};
