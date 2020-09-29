<template>
    <div class="container">
        <div v-for="question in questions" v-bind:key="question.id" class="question" >
            <router-link :to="{ name: 'question', params: { id: question.id }}" class="route">
                <div>{{ question.name }}</div>
                <div class="asked">Asked by {{ question.user.name }}</div>
            </router-link>
        </div>

        <div class="loading" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from "vuex";

    export default {
        name: 'Questions',
        props: [],
        computed: mapGetters(['showResults', 'voted', 'total', 'questions']),
        components: {},
        mounted() {
            this.loading = true;
            this.getQuestions()
                .finally(() => {
                    this.loading = false;
                    console.log(this.questions);
                });
        },
        data() {
            return {
                loading: false,
            }
        },
        methods: {
            ...mapActions(['select', 'getQuestions']),
        }
    }
</script>

<style scoped>
    .container {
        margin-top: 2em;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-direction: column;
    }
    .loading {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .question {
        margin-top: .5em;
        height: 3em;
        width: 100%;
        padding: .5em;
        font-weight: 500;
        color: white;
        background-color: rgb(44, 44, 44);
        cursor: pointer;
        transition: background-color .2s ease-in-out;
    }

    .question:hover {
        background-color: rgb(70, 69, 69);
    }
    .asked {
        font-weight: 600;
        font-size: .8rem;
    }
    .route {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        text-decoration: none;
        background-color: none;
    }
</style>
