<template>
        <div class="container">
        <div class='title'>Create a question</div>

        <form  @submit.prevent="createQuestion()">
            <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Question name</span>
            </div>
            <input v-model="question_name" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="name">
            </div>

            <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Options</span>
            </div>
            <input v-model="question_options" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="separeted by comma">
            </div>

            <button class="btn btn-primary" type="button" @click="createQuestion()">
                <span v-if="creating" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Create
            </button>

        </form>

    </div>
</template>

<script>
    import { mapActions, mapGetters } from "vuex";

    export default {
        name: 'Create',
        props: [],
        computed: mapGetters('questions', ['creating']),
        components: {

        },
        mounted() {

        },
        data() {
            return {
                question_name: '',
                question_options: ''
            }
        },
        methods: {
            ...mapActions('questions', ['create']),
            createQuestion () {
                if (this.question_name && this.question_options.split(',').length) {
                    this.create({
                        name: this.question_name,
                        options: this.question_options.split(',')
                    });
                } else {
                    // handle err
                }

            }
        },
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
