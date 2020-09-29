
require('./bootstrap');

window.Vue = require('vue');

Vue.component('Vote', require('./components/Vote.vue').default);


import store from "./store";
import Vote from "./components/Vote";
import Home from "./components/Home";
import Question from './components/Question';
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: Vote
    },
    {
        path: "/home",
        component: Home,
        name: 'home'
    },
    {
        path: "/question/:id",
        component: Question,
        name: 'question'
    }
];

Vue.use(VueRouter);

export const router = new VueRouter({
    routes,
    mode: 'history'
});

const app = new Vue({
    store,
    router,
    el: '#app',
});
