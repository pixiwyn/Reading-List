<template>
    <div class="card bg-light mb-3">
        <div class="row">
            <div class="col-md-2">
                <img :src="book.cover_img_url" class="card-img" alt="">
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <h5 class="card-title">{{ book.title }}</h5>
                    <div class="card-text" v-html="book.description"></div>
                    <p class="card-text"><small class="text-muted"><span v-for="author in book.authors">{{ author }} </span></small></p>
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
                }
            }
        },
        created() {
            console.log(this.$route.params.id)
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

</style>
