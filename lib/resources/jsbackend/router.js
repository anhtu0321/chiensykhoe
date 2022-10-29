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
// Users
import themuser from './components/users/add.vue';
import suauser from './components/users/edit.vue';
// Đơn vị
import themdonvi from './components/donvi/add.vue';
import suadonvi from './components/donvi/edit.vue';
// Cán bộ
import themcanbo from './components/canbo/add.vue';
import suacanbo from './components/canbo/edit.vue';
const router = new VueRouter({
    routes: [
        { path: '/chucnang', component: themchucnang },
        { path: '/chucnang/edit/:id', component: suachucnang },
        { path: '/role', component: themrole },
        { path: '/role/edit/:id', component: suarole },
        { path: '/users', component: themuser },
        { path: '/users/edit/:id', component: suauser },
        { path: '/donvi', component: themdonvi },
        { path: '/donvi/edit/:id', component: suadonvi },
        { path: '/canbo', component: themcanbo },
        { path: '/canbo/edit/:id', component: suacanbo }
    ]
});

export default router;