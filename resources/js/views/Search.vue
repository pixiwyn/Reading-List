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
        <Paginate :current_page="current_page" :last_page="last_page" @changePage="changePage"/>
    </div>
</template>

<script>
    import BookService from "../services/BookService";
    import BookCard from "../components/BookCard";
    import Paginate from "../components/Paginate";

    export default {
        components: {
            BookCard,
            Paginate
        },
        data() {
            return {
                results: [],
                q: '',
                current_page: 1,
                last_page: 1
            }
        },
        created() {
            const books = JSON.parse(localStorage.getItem('results'));
            this.results = books;
            this.q = localStorage.getItem('q');
            this.last_page = parseInt(localStorage.getItem('last_page'));
            this.current_page = parseInt(localStorage.getItem('current_page'));
        },
        methods: {
            search() {
                BookService.search(this.q, this.current_page).then(({data}) => {
                   const books = data.results;
                   this.results = books;
                   this.last_page = data.numOfPages;
                   this.current_page = data.currentPage;
                   localStorage.setItem('q', this.q.toString());
                   localStorage.setItem('results', JSON.stringify(books));
                   localStorage.setItem('last_page', data.numOfPages);
                   localStorage.setItem('current_page', data.currentPage);
                });
            },
            changePage(page) {
                this.current_page = page;
                this.search();
            },
            add(i) {
                BookService.addToReadingList(this.results[i]).then(({data}) => {
                    console.log(data);
                    this.$router.push('list');
                });
            }
        }
    }
</script>

<style scoped>

</style>
