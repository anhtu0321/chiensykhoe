import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

// import cac component o duoi:
// -Chức năng
import themchucnang from './components/chucnang/add.vue';
import suachucnang from './components/chucnang/edit.vue';
// group chức năng (role)
import themrole from './components/group/add.vue';
import suarole from './components/group/edit.vue';
const router = new VueRouter({
    routes: [
        { path: '/chucnang', component: themchucnang },
        { path: '/chucnang/edit/:id', component: suachucnang },
        { path: '/role', component: themrole },
        { path: '/role/edit/:id', component: suarole },
    ]
});

export default router;