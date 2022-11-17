import Vue from 'vue'
import VueX from 'vuex'
Vue.use(VueX)

const store = new VueX.Store({
    state: {
        listQuytac: '',
        listMonthi: '',
        listDonvi: '',
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
        },
        acListMonthi(contex) {
            var n = 0;

            function load() {
                axios.get('/chiensykhoe/listMonthi')
                    .then(response => {
                        contex.commit('muListMonthi', response.data);
                    })
                    .catch(e => {
                        n += 1;
                        console.log('error: load listMonthi');
                        if (n < 3) {
                            load();
                        }
                    })
            }
            load();
        },
        acListDonvi(contex) {
            var n = 0;

            function load() {
                axios.get('/chiensykhoe/listDonvi')
                    .then(response => {
                        contex.commit('muListDonvi', response.data);
                    })
                    .catch(e => {
                        n += 1;
                        console.log('error: load listDonvi');
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
        },
        muListMonthi(state, data) {
            state.listMonthi = data;
        },
        muListDonvi(state, data) {
            state.listDonvi = data;
        }
    }
});

export default store;