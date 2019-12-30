import Vue from 'vue'

export default {
    getReadingList(page, order_by, direction) {
        return Vue.axios.get(`list?page=${page}&order_by=${order_by}&direction=${direction}`);
    },
    getBookDetails(id, bookType) {
        return Vue.axios.get(`books/${id}?bookType=${bookType}`);
    },
    removeFromReadingList(id) {
        return Vue.axios.delete(`books/${id}`);
    },
    addToReadingList(book) {
        return Vue.axios.post('books', book);
    },
    search(q, page) {
        return Vue.axios.get(`books?q=${q}&page=${page}`);
    },
}
