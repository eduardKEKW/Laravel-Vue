
require('./bootstrap');

window.Vue = require('vue');

Vue.component('Vote', require('./components/Vote.vue').default);


import Vote from "./components/Vote";
import Home from "./components/Home";
import Create from "./components/Create";
import Question from './components/Question';

import VueRouter from "vue-router";
import store from "./store";

const routes = [
    {
        path: "/",
        component: Vote
    },
    {
        path: "/home",
        component: Home,
        name: "home"
    },
    {
        path: "/question/:id",
        component: Question,
        name: "question"
    },
    {
        path: "/create",
        component: Create,
        name: "create"
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
