import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import themDanhSach from './components/dskiemtra/add.vue';
import themQuyTac from './components/quytac/add.vue';

const router = new VueRouter({
    routes: [
        { path: '/danhsach', component: themDanhSach },
        { path: '/quytac', component: themQuyTac },
    ]
});

export default router;