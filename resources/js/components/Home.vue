<template>
    <div class="home">
        <div class="question">
            <h2 class="title">Pick a question</h2>

            <div class="">
                <Questions></Questions>
            </div>
        </div>
        <div class="or">
           <p>Or</p>
        </div>
        <div class="create">
            <h2 class="title">Create one</h2>

            <div class="content">

            <router-link :to="{ name: 'create' }" class="route">
                <button type="button" class="btn btn-dark">Create</button>
            </router-link>

            </div>
        </div>
    </div>
</template>

<script>
    import Questions from './Questions';

    export default {
        name: 'Home',
        props: [],
        components: {
            Questions
        },
        mounted() {

        },
        data() {
            return {

            }
        },
        methods: {

        },
    }
</script>

<style scoped>
    .home {
        width: 60%;
        margin: 0 auto;
        display: flex;
        margin-top: 10%;
    }
    .or {
        width: 10%;
        min-height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.4rem;
        font-weight: 700;

    }
    .title {
        width: 100%;
        text-align: center;
        font-weight: 700;
        font-size: 1.3rem;
    }
    .question {
        width: 50%;
        min-height: 30em;
    }
    .create {
        width: 50%;
    }
    .content {
        min-height: 90%;
        display: flex;
        align-items: center;
        justify-content: center;

    }
</style>
