import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import themDanhSach from './components/dskiemtra/add.vue';

const router = new VueRouter({
    routes: [
        { path: '/danhsach', component: themDanhSach },
    ]
});

export default router;