<template>
    <div id="list-component">

        <div class="row">
            <div class="col-sm-6">
            <Paginate :current_page="current_page" :last_page="last_page" @changePage="changePage"/>
            </div>
            <div class="col-sm-3">
                <select class="form-control" v-model="order_by" @change="fetch">
                    <option value="created_at">Date Added</option>
                    <option value="title">Title</option>
                    <option value="authors">Authors</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-control" v-model="direction" @change="fetch">
                    <option>ASC</option>
                    <option>DESC</option>
                </select>
            </div>
        </div>
        <BookCard v-for="(book, i) in list" :key="book.id" :book="book" :i="i" bookType="list" @removeFromList="remove"/>
    </div>
</template>

<script>
import BookService from "../services/BookService";
import BookCard from "../components/BookCard";
import Paginate from "../components/Paginate";
import Search from "./Search";

export default {
    components: {
        Search,
        BookCard,
        Paginate
    },
    data() {
        return {
            list:[],
            total: 0,
            current_page: 1,
            last_page: 1,
            order_by: 'created_at',
            direction: 'DESC'
        }
    },
    methods: {
        remove(i) {
          console.log('delete', i);
          BookService.removeFromReadingList(this.list[i].id);
          this.list.splice(i, 1);
        },
        changePage(page) {
            this.current_page = page;
            this.fetch();
        },
        fetch() {
            BookService.getReadingList(this.current_page, this.order_by, this.direction)
                .then(({data}) => {
                    this.list = data.books.data;
                    this.total = data.books.total;
                    this.current_page = data.books.current_page;
                    this.last_page = data.books.last_page;
                });
        }
    },
    created() {
        this.fetch();
    }
}
</script>
