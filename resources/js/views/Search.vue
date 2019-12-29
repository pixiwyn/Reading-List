<template>
    <div>
        <form @submit.prevent="search()">
            <div class="input-group mb-3">
                <input type="text" class="form-control" v-model="q" placeholder="Search term..." />
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <BookCard v-for="(book, i) in results" :key="book.id" :book="book" :i="i" bookType="search" @addToList="add"/>
    </div>
</template>

<script>
    import BookService from "../services/BookService";
    import BookCard from "../components/BookCard";

    export default {
        components: {
            BookCard
        },
        data() {
            return {
                results: [],
                q: ''
            }
        },
        created() {
            const books = JSON.parse(localStorage.getItem('results'));
            this.results = books;
            this.q = localStorage.getItem('q');
        },
        methods: {
            search() {
                BookService.search(this.q).then(({data}) => {
                   const books = data.results;
                   this.results = books;
                   localStorage.setItem('q', this.q.toString());
                   localStorage.setItem('results', JSON.stringify(books));
                });
            },
            add(i) {
                BookService.addToReadingList(this.results[i]).then(({data}) => {
                    console.log(data);
                });
            }
        }
    }
</script>

<style scoped>

</style>
