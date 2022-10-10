import Vue from 'vue'
import VueX from 'vuex'
Vue.use(VueX)
import StoreInfo from './store/storeinfo'
const store = new VueX.Store(
    StoreInfo
)

export default store;