const storeInfo = {
    state: {
        listChucNangCha: '',
        listChucNang: '',
        listRole: '',
        pageChucNang: 1,
        pageRole: 1,
    },
    getters: {
        getChucNangCha() {
            return state.listChucNangCha;
        }
    },
    actions: {
        // chuc nang permission
        acListChucNangCha(contex) {
            var n = 0;

            function load() {
                axios.get('/chiensykhoe/admin/listChucNangCha')
                    .then(response => {
                        contex.commit('muListChucNangCha', response.data);
                    })
                    .catch(e => {
                        n += 1;
                        console.log('error: load listChucNangCha');
                        if (n < 5) {
                            load();
                        }
                    })
            }
            load();
        },
        acListChucNang(contex, page) {
            var n = 0;

            function load() {
                axios.get('/chiensykhoe/admin/listChucNang?page=' + page)
                    .then(response => {
                        contex.commit('muListChucNang', response.data);
                    })
                    .catch(e => {
                        n += 1;
                        console.log('error: load listChucNang');
                        if (n < 5) {
                            load();
                        }
                    })
            }
            load();
        },
        acPageChucNang(contex, page) {
            contex.commit('muPageChucNang', page)
        },
        // Nhom group role
        acListRole(contex, page) {
            var n = 0;

            function load() {
                axios.get('/chiensykhoe/admin/listRole?page=' + page)
                    .then(response => {
                        contex.commit('muListRole', response.data);
                    })
                    .catch(e => {
                        console.log('error: load listRole');
                        n += 1;
                        if (n < 5) {
                            load();
                        }
                    })
            }
            load();
        },
        acPageRole(contex, page) {
            contex.commit('muPageRole', page)
        },
    },
    mutations: {
        muListChucNangCha(state, data) {
            state.listChucNangCha = data;
        },
        muListChucNang(state, data) {
            state.listChucNang = data;
        },
        muPageChucNang(state, page) {
            state.pageChucNang = page;
        },
        muListRole(state, data) {
            state.listRole = data;
        },
        muPageRole(state, page) {
            state.pageRole = page;
        },
    }
}

export default storeInfo;