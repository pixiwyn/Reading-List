<template>
    <div class="card bg-light mb-3">
        <div class="row">
            <div class="col-md-2">
                <img :src="book.cover_img_url" class="card-img" alt="">
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <h5 class="card-title">{{ book.title }}</h5>
                    <p class="card-text">{{ book.description | truncate(250) }}</p>
                    <p class="card-text"><small class="text-muted"><span v-for="author in book.authors">{{ author }} </span></small></p>
                    <a :href="`/details/${book.id}/${bookType}`" class="btn btn-primary"><i class="fas fa-external-link-alt"></i></a>
                    <button @click="add(i)" class="btn btn-success" v-show="bookType === 'search'"><i class="far fa-bookmark"></i></button>
                    <button @click="remove(i)" class="btn btn-danger" v-show="bookType === 'list'"><i class="far fa-trash-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookCard",
        props: {
            book: Object,
            i: Number,
            bookType: String
        },
        data() {
            return {

            }
        },
        methods: {
            remove(i) {
                this.$emit('removeFromList', i);
            },
            add(i) {
                this.$emit('addToList', i);
            }
        }
    }
</script>

<style scoped>

</style>
