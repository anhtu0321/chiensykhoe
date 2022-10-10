require('./bootstrap');
import Vue from 'vue';

import appComponent from './app.vue'
import store from './store'
import router from './router'
import swal from 'sweetalert';
const app = new Vue({
    el: '#appbackend',
    components: {
        appComponent,
    },
    router: router,
    store: store,
});