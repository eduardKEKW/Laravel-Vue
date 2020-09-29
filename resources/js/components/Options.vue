<template>
    <div class="container">
        <div class="option">Please Select One</div>
         <div v-bind:key="question.id" v-for="question in questions">
            <Question
                v-bind:voted="voted === question.id"
                v-bind:total="total"
                v-bind:showResults="showResults"
                v-bind:data="question"
                v-on:select="select"
                v-bind:loading="question.id === loading" />
        </div>
    </div>
</template>

<script>
    //v-bind:voted="user && user.vote && user.vote.question_id"
    import Option from './Option';
    import axios from 'axios';

    export default {
        name: 'Questions',
        components: {Question},
        props: ['voted'],
        mounted() {
            this.getQuestion()
        },

        data() {
            return {
                questions: [],
                loading: -1,
                showResults: false,
                total: 0,
            }
        },

        methods: {

        }
    }
</script>

<style scoped>
     .container {
        padding-top: 10%;
        width: 30%;
        margin: 0 auto;
    }
    .option {
        width: 100%;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2em;
        text-align: center;
    }
</style>
