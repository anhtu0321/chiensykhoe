<template>
    <div id="danhsach">
        <div class="danh-sach">
            <div class="danh-sach__title">{{ title }}</div>
            <div class="danh-sach__content">
                <form method="post" @submit.prevent='add'>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Tên Môn thi</label>
                            <input type="text" class="form-control" v-model="ten_mon_thi">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12" v-if="mode=='add'">
                            <button class="btn btn-info">Thêm Môn thi</button>
                        </div>
                        <div class="form-group col-md-12" v-if="mode=='edit'"> 
                            <button class="btn btn-info" @click.prevent="update(idEdit)">Sửa Môn thi</button>
                            <button class="btn btn-warning" @click.prevent="back">Quay lại</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- danh sach quy tac -->
        <div class="list">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên Môn thi</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list, index) in listData.data" :key="list.id" :class="list.id == idEdit? 'tractive':''">
                    <th scope="row">{{index+1}}</th>
                    <td width="75%">{{list.ten_mon_thi}}</td>
                    <td width="22%">
                        <button class="btn btn-warning" @click="edit(list.id)">Sửa</button>
                        <button class="btn btn-danger" @click="deleted(list.id)">Xóa</button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- end -->

    </div>
</template>

<script>
export default {
    data(){
        return {
            title:'THÊM MÔN THI',
            mode:'add',
            ten_mon_thi:'',
            idEdit:'',
        }
    },
    computed:{
        listData(){
            return this.$store.state.listMonthi;
        }
    },
    methods:{
        add(){
            let data = new FormData();
            data.append('ten_mon_thi', this.ten_mon_thi);
            axios.post('/chiensykhoe/addMonthi', data)
            .then(response=>{
                this.ten_mon_thi="";
                this.$store.dispatch('acListMonthi');
            })
            .catch(err=>{
                
            })
        },
        edit(id){
            this.mode = 'edit';
            this.title = "SỬA MÔN THI";
            this.idEdit = id;
            axios.get('/chiensykhoe/editMonthi/'+id)
            .then(response=>{
                this.ten_mon_thi = response.data.ten_mon_thi;
            })
            .catch(error=>{

            })
        },
        update(id){
            let data = new FormData();
            data.append('ten_mon_thi', this.ten_mon_thi);
            axios.post('/chiensykhoe/updateMonthi/'+id, data)
            .then(response=>{
                this.$store.dispatch('acListMonthi');
                swal('update thành công !');
            })
            .catch(err=>{
                
            })
        },
        deleted(id){
            swal('Bạn có chắc chắn muốn xóa nó ???',{
                buttons:{
                    cancel:'Hủy bỏ',
                    delete:'Xóa'
                }
            })
            .then(value=>{
                if(value == 'cancel'){
                    swal('Bạn đã hủy lệnh');
                }
                if(value == 'delete'){
                    axios.get('/chiensykhoe/deleteMonthi/'+id)
                    .then(res=>{
                        this.$store.dispatch('acListMonthi');
                        swal('Xóa Thành công !');
                    })
                    .catch(e=>{
                        swal('Bạn không có quyền thực hiện thao tác này !');
                    })
                }
            })
        },
        back(){
            this.mode = 'add';
            this.ten_mon_thi = '';
            this.title = "THÊM MÔN THI";
            this.idEdit = '';
        },
        loadDataModal(id){
            // alert('here');
        }
    },
    mounted(){
        if(this.$store.state.listMonthi==''){
            this.$store.dispatch('acListMonthi');
        }
    }
}
</script>

<style lang="scss" scoped>
    .danh-sach{
        font-family: 'Montserrat';
        position:relative;
    }
    .danh-sach__content{
        border:1px solid #bbbbbb;
        padding:10px;
        border-radius:5px;
        margin-top:30px;
    }
    .danh-sach__title{
        position:absolute;
        height:20px;
        line-height: 20px;
        font-size: 1.1em;
        font-weight: bold;
        background:#ffffff;
        left:30px;
        top:-10px;
        padding:0px 10px;
    }
   
    .modal-lga{
        max-width:1000px;
    }
</style>>

