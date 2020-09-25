<template>
    <div class="question alert alert-secondary" v-bind:class="{'alert-success': voted}"  @click="select">
        <div>{{ data.name }}</div>
        <div class="results">
            {{data.answears_count}} / {{total}} Votes ( {{ data.answears_count ? Math.round((data.answears_count / total) / Math.pow(10, -2), 2) : 0 }}% )
        </div>
        <div v-if="loading" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Question',
        props: ["data", "loading", "total", "voted"],
        components: {},
        mounted() {},

        data() {
            return {

            }
        },

        methods: {
            select () {
                this.$emit('select', this.data.id);
            }
        }
    }
</script>

<style scoped>
    .question {
        cursor: pointer;
        display: flex;
        align-content: center;
        justify-content: space-between;
        font-weight: 600;
    }

    .question:hover {
        background-color: rgb(38, 104, 82);
        color: white;
    }
</style>
