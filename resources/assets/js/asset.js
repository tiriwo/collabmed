require('./bootstrap');
import axios from 'axios';
import Vue from 'vue';
window.axios= axios;
Vue.component('asset-component', require('./components/AssetComponent'));
new Vue({
    el: '#asset',
    data(){
       return {test:'me'}
    },
    mounted() {
        console.log('Component mounted.')
    },
});