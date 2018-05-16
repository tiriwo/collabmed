require('./bootstrap');
import axios from 'axios';
import Vue from 'vue';
window.axios= axios;
Vue.component('category-component', require('./components/CategoryComponent'));
Vue.component('user-component', require('./components/UserComponent'));
Vue.component('borrow-component', require('./components/BorrowComponent'));
new Vue({
   el:'#app',
});