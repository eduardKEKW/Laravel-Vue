<template>
    <div class="container">
        <Register v-show="!loggedIn" v-on:register="register" v-on:login="login"></Register>
        <!-- <Options v-show="loggedIn" ></Options> -->
    </div>
</template>

<script>
    import { mapGetters, mapActions } from "vuex";
    import Register from './Register';
    // import Options from './Options';

    export default {
        name: 'Vote',
        components: {
            Register,
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
