import Vue from 'vue'
import VueX from 'vuex'
Vue.use(VueX)

const store = new VueX.Store({
    state: {
        listQuytac: '',
    },
    getters: {},
    actions: {
        acListQuytac(contex) {
            var n = 0;

            function load() {
                axios.get('/chiensykhoe/listQuytac')
                    .then(response => {
                        contex.commit('muListQuytac', response.data);
                    })
                    .catch(e => {
                        n += 1;
                        console.log('error: load listQuytac');
                        if (n < 3) {
                            load();
                        }
                    })
            }
            load();
        }
    },
    mutations: {
        muListQuytac(state, data) {
            state.listQuytac = data;
        }
    }
});

export default store;