require('./bootstrap');
import axios from 'axios';
import Vue from 'vue';
window.axios= axios;
Vue.component('category-component', require('./components/CategoryComponent'));
new Vue({
    el: '#category',
});