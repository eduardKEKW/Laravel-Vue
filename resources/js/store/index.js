import Vuex from "vuex";
import Vue from "vue";
import app from "./modules/app";
import questions from "./modules/questions";


Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        app,
        questions
    }
});
