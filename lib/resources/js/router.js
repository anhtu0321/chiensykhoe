import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import themDanhSach from './components/dskiemtra/add.vue';
import themQuyTac from './components/quytac/add.vue';
import themMonThi from './components/monthi/add.vue';
import themCanBo from './components/themcanbo/add.vue';
import kiemTra from './components/dskiemtra/kiemtra.vue';

const router = new VueRouter({
    routes: [
        { path: '/danhsach', component: themDanhSach },
        { path: '/quytac', component: themQuyTac },
        { path: '/monthi', component: themMonThi },
        { path: '/themcanbo/:id', component: themCanBo },
        { path: '/kiemtra/:id', component: kiemTra },
    ]
});

export default router;