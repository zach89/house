// window.$ = window.jQuery = require('jquery');
// import Vue from 'Vue';
// import axios from 'axios';
// axios.defaults.headers.common = {
//     'X-Requested-With': 'XMLHttpRequest'
// };
require('./bootstrap');

Vue.component('data-table', require('./components/Table.vue'));

const app = new Vue({
    el: '#app'
});