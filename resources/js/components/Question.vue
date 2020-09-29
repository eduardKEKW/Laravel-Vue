<template>
    <div class="container">

        <div v-if="loading" class="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

    <div v-else class="question">
        <div class="question_title">
            {{ question.name }}
            <div v-if="canUpdate" class="delete_question" title="Delete the question?" @click="delQuestion()">
                <IconDelete></IconDelete>
            </div>
        </div>

        <div class="options">
            <div
                v-bind:key="option.id" v-for="option in question.options"
                class="option alert alert-secondary"
                v-bind:class="{'alert-success': userVotedOn === option.id}"
                @click="voteOn(option.id)" >

                <div>{{ option.name }}</div>
                <div v-if="userVotedOn" class="results">
                    {{option.votes_count}} / {{total}} Vote(s) ( {{ option.votes_count ? Math.round((option.votes_count / total) / Math.pow(10, -2), 2) : 0 }}% )
                </div>

                <div v-if="loadingVote === option.id" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

        </div>
    </div>

    </div>
</template>

<script>
    import { mapActions, mapGetters } from "vuex";
    import IconDelete from './DeleteIcon';

    export default {
        name: 'Question',
        props: [],
        computed: {
            ...mapGetters('questions', ['question', 'loading', 'total', 'loadingVote', 'userVotedOn']),
            ...mapGetters(['user', 'loggedIn'])
        },
        components: {IconDelete},
        mounted() {
            this.getMe();
            this.getQuestion(this.$route.params.id)
                .finally((res) => {
                    this.canUpdate = (this.user && this.user.id) === this.question.user.id;
                });
        },
        data() {
            return {
                canUpdate: false
            }
        },
        methods: {
            ...mapActions('questions', ['getQuestion', 'vote', 'destroy']),
            ...mapActions(['getMe']),
            voteOn (_id) {
                this.vote(_id);
            },
            delQuestion() {
                this.destroy(this.question.id);
            },
            delOption(_id) {

            }
        },
    }
</script>

<style scoped>
     .option {
        cursor: pointer;
        display: flex;
        align-content: center;
        justify-content: space-between;
        font-weight: 600;
        width: 40%;
        padding: 1em;
        margin: .5em auto;
        position: relative;
    }
    .loading {
        width: 100%;
        height: 25vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loading > .spinner-border {
        font-size: 1rem;
        font-weight: 900;
    }
    .delete_option {
        position: absolute;
        top: 0%;
        left: 110%;
    }
    .option:hover {
        background-color: rgb(38, 104, 82);
        color: white;
    }
    .question_title {
        width: 100%;
        font-weight: 600;
        font-size: 1.2rem;
        text-align: center;
        margin-bottom: 1.5em;
    }
    .container {
        width: 60%;
        margin: 0 auto;
        margin-top: 10%;
    }
    .question {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .options {
        width: 100%;
    }
    .spinner-border {
        font-size: .3rem;
        height: 5em;
        width: 5em;
    }
    .delete_question:hover {
        color: red;
        cursor: pointer;
    }
    .delete_question {
        margin-left: 1em;
        display: inline-block;
    }
</style>
