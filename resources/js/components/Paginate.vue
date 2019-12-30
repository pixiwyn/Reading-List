<template>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li :class="[{'disabled': current_page === 1},'page-item']">
                <a class="page-link" @click="changePage(current_page - 1)" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="p in last_page" :class="[{'active': p === current_page},'page-item']">
                <a class="page-link" @click="changePage(p)" href="#">{{p}}</a>
            </li>
            <li :class="[{'disabled': current_page === last_page},'page-item']">
                <a class="page-link" @click="changePage(current_page + 1)" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Paginate",
        props: {
            current_page: Number,
            last_page: Number
        },
        methods: {
            changePage(page) {
                this.$emit('changePage', page);
            },
        }
    }
</script>

<style scoped>

</style>
