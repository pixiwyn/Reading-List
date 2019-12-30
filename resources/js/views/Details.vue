<template>
    <div class="card bg-light mb-3">
        <div class="row">
            <div class="col-md-2">
                <img :src="book.cover_img_url" class="card-img" alt="">
                <div class="buttons">
                    {{book.average_rating}} <i class="fas fa-star"></i> ({{book.ratings_count}} ratings)
                </div>
                <div class="buttons">
                    <button @click="add(book)" class="btn btn-success" v-show="bookType === 'search'"><i class="far fa-bookmark"></i></button>
                    <a :href="book.buy_link" class="btn btn-primary"><i class="fab fa-google-play"></i></a>
                    <button @click="remove(book.id)" class="btn btn-danger" v-show="bookType === 'list'"><i class="far fa-trash-alt"></i></button>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <h5 class="card-title">{{ book.title }}</h5>
                    <div class="card-text" v-html="book.description"></div>
                    <p class="card-text"><small class="text-muted"><span>{{ book.authors }} | {{ book.published_date | moment('MMMM Do, YYYY')}}</span></small></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BookService from "../services/BookService";

    export default {
        data() {
            return {
                book: {
                    title: '',
                    description: ''
                },
                bookType: 'list'
            }
        },
        methods: {
            remove(id) {
                BookService.removeFromReadingList(id).then(() => {
                    this.$router.push('/list');
                });
            },
            add(book) {
                BookService.addToReadingList(book).then(({data}) => {
                    console.log(data);
                    this.$router.push('/list');
                });
            }
        },
        created() {
            console.log(this.$route.params.id)
            this.bookType = this.$route.params.bookType;
            BookService.getBookDetails(this.$route.params.id, this.$route.params.bookType).then(({data}) => {
                console.log(data);
                this.book = data.details;
            })
        }
    }
</script>

<style scoped>

    img {
        margin-top: 25px;
        margin-left: 25px;
    }

    .buttons {
        margin-top: 15px;
        margin-left: 25px;
    }

</style>
