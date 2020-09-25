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
    import Question from './Question';
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
            select (_id) {
                this.loading = _id;

                axios.post(`/api/questions/${_id}/vote`)
                    .then((response) => {
                        this.showResults = true;
                        this.loading = -1;
                        this.voted = _id;
                        this.getQuestion();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            },

            getQuestion () {
                axios.get('/api/questions')
                    .then((response) => {
                        this.loading = false;
                        this.total = response.data.reduce((acc,curr) => acc + curr.answears_count, 0);
                        this.questions = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
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
    .option {
        width: 100%;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2em;
        text-align: center;
    }
</style>
