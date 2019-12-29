import Vue from 'vue'

export default {
    getReadingList() {
        return Vue.axios.get('list');
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
    search(q) {
        return Vue.axios.get(`books?q=${q}`);
    },
}
