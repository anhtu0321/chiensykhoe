<template>
    <div id="danhsach">
        <div class="danh-sach">
            <div class="danh-sach__title">{{ title }}</div>
            <div class="danh-sach__content">
                <form method="post" @submit.prevent='add'>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Tên quy tắc</label>
                            <input type="text" class="form-control" v-model="ten_quy_tac">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12" v-if="mode=='add'">
                            <button class="btn btn-info" data-toggle="modal" data-target="#listluat">Thêm quy tắc</button>
                        </div>
                        <div class="form-group col-md-12" v-if="mode=='edit'"> 
                            <button class="btn btn-info" @click.prevent="update(idEdit)">Sửa quy tắc</button>
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
                    <th scope="col">Tên quy tắc</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list, index) in listData.data" :key="list.id" :class="list.id == idEdit? 'tractive':''">
                    <th scope="row">{{index+1}}</th>
                    <td width="75%">{{list.ten_quy_tac}}</td>
                    <td width="22%">
                        <button class="btn btn-success">Quản lý luật</button>
                        <button class="btn btn-warning" @click="edit(list.id)">Sửa</button>
                        <button class="btn btn-danger" @click="deleted(list.id)">Xóa</button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- end -->
        <!-- modal danh sach luat -->
        <div class="modal fade" id="listluat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Đổi mật khẩu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="far fa-window-close"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->
    </div>
</template>

<script>
export default {
    data(){
        return {
            title:'THÊM QUY TẮC XẾP LOẠI',
            mode:'add',
            ten_quy_tac:'',
            idEdit:'',
        }
    },
    computed:{
        listData(){
            return this.$store.state.listQuytac;
        }
    },
    methods:{
        add(){
            let data = new FormData();
            data.append('ten_quy_tac', this.ten_quy_tac);
            axios.post('/chiensykhoe/addQuyTac', data)
            .then(response=>{
                this.ten_quy_tac="";
                this.$store.dispatch('acListQuytac');
            })
            .catch(err=>{
                
            })
        },
        edit(id){
            this.mode = 'edit';
            this.title = "SỬA QUY TẮC XẾP LOẠI";
            this.idEdit = id;
            axios.get('/chiensykhoe/editQuytac/'+id)
            .then(response=>{
                this.ten_quy_tac = response.data.ten_quy_tac;
            })
            .catch(error=>{

            })
        },
        update(id){
            let data = new FormData();
            data.append('ten_quy_tac', this.ten_quy_tac);
            axios.post('/chiensykhoe/updateQuytac/'+id, data)
            .then(response=>{
                this.$store.dispatch('acListQuytac');
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
                    axios.get('/chiensykhoe/deleteQuytac/'+id)
                    .then(res=>{
                        this.$store.dispatch('acListQuytac');
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
            this.ten_quy_tac = '';
            this.title = "THÊM QUY TẮC XẾP LOẠI";
            this.idEdit = '';
        }
    },
    mounted(){
        if(this.$store.state.listQuytac==''){
            this.$store.dispatch('acListQuytac');
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
    .tractive, tractive:hover{
        background:rgb(171, 204, 178);

    }
</style>>

