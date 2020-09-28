<template>
    <div class="container">
        <Register v-show="!loggedIn" v-on:register="register" v-on:login="login"></Register>
        <Questions v-show="loggedIn" ></Questions>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from "vuex";
    import Register from './Register';
    import Questions from './Questions';
    import axios from 'axios';

    export default {
        name: 'Vote',
        components: {
            Register,
            Questions
        },
        computed: mapGetters(['user', 'loggedIn', 'errors']),
        mounted() {
            this.getMe();
        },
        data() {
            return { }
        },

        methods: {
            ...mapActions(['register', 'login', 'getMe']),
        }
    }
</script>

<style scoped>
</style>
