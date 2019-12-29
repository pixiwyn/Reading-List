<template>
    <div id="list-component">
        <BookCard v-for="(book, i) in list" :key="book.id" :book="book" :i="i" bookType="list" @removeFromList="remove"/>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
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
            list:[]
        }
    },
    methods: {
      remove(i) {
          console.log('delete', i);
          BookService.removeFromReadingList(this.list[i].id);
          this.list.splice(i, 1);
      }
    },
    created() {
        BookService.getReadingList()
            .then(({data}) => {
               this.list = data.books
            });
    }
}
</script>
