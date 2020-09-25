<template>
    <div class="container">
        <Register v-show="!loggedIn" v-on:register="register" v-on:login="login"></Register>
        <Questions v-show="loggedIn" v-bind:voted="user && user.vote && user.vote.question_id" ></Questions>
    </div>
</template>

<script>
    import Register from './Register';
    import Questions from './Questions';
    import axios from 'axios';

    export default {
        name: 'Vote',
        components: {
            Register,
            Questions
        },
        mounted() {
            const token =  localStorage.getItem('token');

            if (token) {
                axios.defaults.headers.common = {'Authorization': `Bearer ${token}`};

                axios.get('/api/auth/me')
                    .then((response) => {
                        console.log(response);
                        this.loggedIn = true;
                        this.user = response.data.user;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },

        data() {
            return {
                loggedIn: false,
                user: null,
                voted: null,
            }
        },

        methods: {
            register(data) {
                axios.post('/api/auth/register', data)
                    .then((response) => {
                        this.saveToken (response.data.token);
                        this.loggedIn = true;
                        this.user = response.data.user;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            login(data) {
                axios.post('/api/auth/signin', data)
                    .then((response) => {
                        this.saveToken (response.data.token);
                        this.loggedIn = true;
                        this.user = response.data.user;
                        this.voted = this.user.vote.question_id;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            saveToken (token) {
                axios.defaults.headers.common = {'Authorization': `Bearer ${token}`};
                localStorage.setItem('token',token);
            }
        }
    }
</script>

<style scoped>
</style>
