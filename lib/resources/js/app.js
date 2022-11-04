require('./bootstrap');
import Vue from 'vue';

import appComponent from './app.vue';
import doiMatKhau from './components/doimatkhau.vue';
import store from './store';
import router from './router';
import swal from 'sweetalert';
const app = new Vue({
    el: '#app',
    components: {
        appComponent,
        doiMatKhau
    },
    router: router,
    store: store,
});