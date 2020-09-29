<template>
    <div class="container">
        <div class='title'>Register</div>

        <form  @submit.prevent="register($event)">
            <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
            </div>
            <input v-model="name_register" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="name">
            </div>

              <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Email</span>
            </div>
            <input v-model="email_register" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="email">
            </div>

            <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Password</span>
            </div>
            <input v-model="password_register" type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="password">
            </div>

            <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Confirm Password</span>
            </div>
            <input v-model="confirm_register" type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="confirm">
            </div>

            <!-- <input class="btn btn-primary" type="submit" value="Register"> -->
            <button class="btn btn-primary" type="button" @click="register()">
                <span v-if="loadingSignIn" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Register
            </button>

        </form>

        <div class='title'>Or Login</div>


        <form  @submit.prevent="login($event)">
              <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Email</span>
            </div>
            <input v-model="email_login" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="email">
            </div>

            <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Password</span>
            </div>
            <input v-model="password_login" type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="password">
            </div>

            <!-- <input class="btn btn-primary" type="submit" value="Login"> -->
            <button class="btn btn-primary" type="button" @click="login()">
                <span v-if="loadingSignIn" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Login
            </button>
        </form>

    </div>
</template>

<script>
    import { mapActions, mapGetters } from "vuex";


    export default {
        mounted() {},
        data() {
            return {
                name_register: '',
                email_register: '',
                password_register: '',
                confirm_register: '',
                email_login: '',
                password_login: '',
            }
        },
        computed: mapGetters(['loadingSignIn']),
        methods: {
            register() {
                this.$emit('register', {
                    name: this.name_register,
                    email: this.email_register,
                    password: this.password_register,
                    password_confirmation: this.confirm_register
                });
            },

            login() {
                this.$emit('login', {
                    email: this.email_login,
                    password: this.password_login,
                });
            }
        }
    }
</script>

<style scoped>
    .container {
        padding-top: 10%;
        width: 30%;
        margin: 0 auto;
    }

    .title {
        font-size: 2rem;
        font-weight: 700;
        width: 100%;
        text-align: center;
        margin-bottom: 1em;
    }
</style>
