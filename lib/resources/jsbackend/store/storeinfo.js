const storeInfo = {
    state: {
        listChucNangCha: '',
        listChucNang: '',
        pageChucNang: 1,
        listRole: '',
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
            axios.get('/chiensykhoe/admin/listChucNangCha')
                .then(response => {
                    contex.commit('muListChucNangCha', response.data);
                })
                .catch(e => {
                    console.log("loi");
                    this.$store.dispatch('acListChucNangCha');
                })
        },
        acListChucNang(contex, page) {
            axios.get('/chiensykhoe/admin/listChucNang?page=' + page)
                .then(response => {
                    contex.commit('muListChucNang', response.data);
                })
                .catch(e => {
                    this.acListChucNang(contex, page);
                })
        },
        acPageChucNang(contex, page) {
            contex.commit('muPageChucNang', page)
        },
        // Nhom group role
        acListRole(contex, page) {
            axios.get('/chiensykhoe/admin/listRole?page=' + page)
                .then(response => {
                    contex.commit('muListRole', response.data);
                })
                .catch(e => {
                    this.acListRole(context, page);
                })
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