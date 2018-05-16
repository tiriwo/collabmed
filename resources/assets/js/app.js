require('./bootstrap');
import CategoryComponent from './components/CategoryComponent';

window.Vue = require('vue');
window.axios= require('axios');

Vue.component('category-component', CategoryComponent);

new Vue({
    el: '#category'
});
