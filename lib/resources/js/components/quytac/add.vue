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
                            <button class="btn btn-info">Thêm quy tắc</button>
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
                        <button class="btn btn-success" data-toggle="modal" data-target="#listluat" @click="loadDataModal(list.id)">Quản lý luật</button>
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
            <div class="modal-dialog modal-lga" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Danh sách luật</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
						<!-- form thêm luật -->
                        <div class="danh-sach">
                            <div class="danh-sach__title">Thêm luật</div>
                            <div class="danh-sach__content">
                                <form method="post" @submit.prevent='addLuat'>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="">Nhóm tuổi</label>
											<div class="form-inline">
												<input type="text" class="form-control" v-model="min_age" placeholder="Thấp nhất">
												<input type="text" class="form-control" v-model="max_age" placeholder="Cao nhất">
											</div>
                                        </div>
										<div class="form-group col-md-6">
                                            <label for="">Đối tượng/ Giới tính</label>
                                            <select class="form-control" v-model="gioi_tinh">
												<option value="0">Nam Cán bộ</option>
												<option value="1">Nam Cảnh vệ</option>
												<option value="2">Nữ cán bộ</option>
											</select>
                                        </div>
                                    </div>
									<div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="">Môn thi</label>
											<select class="form-control" v-model="mon_thi">
												<option v-for="list in listMonthi.data" :key="list.id" :value="list.id">{{list.ten_mon_thi}}</option>
											</select>
                                        </div>
										<div class="form-group col-md-3">
                                            <label for="">Điểm đạt</label>
                                            <input type="text" class="form-control" v-model="dat" placeholder="Thấp nhất">
                                        </div>
										<div class="form-group col-md-3">
                                            <label for="">Điểm khá</label>
                                            <input type="text" class="form-control" v-model="kha" placeholder="Thấp nhất">
                                        </div>
										<div class="form-group col-md-3">
                                            <label for="">Điểm giỏi</label>
                                            <input type="text" class="form-control" v-model="gioi" placeholder="Thấp nhất">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 text-right" v-if="modeLuat=='add'">
                                            <button class="btn btn-info">Thêm Luật</button>
                                        </div>
                                        <div class="form-group col-md-12 text-right" v-if="modeLuat=='edit'"> 
                                            <button class="btn btn-info" @click.prevent="updateLuat(id_luat)">Sửa</button>
                                            <button class="btn btn-warning" @click.prevent="backLuat">Quay lại</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
						<!-- end -->
                        <!-- danh sach luật -->
                        <div class="list">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nhóm tuổi</th>
                                    <th scope="col">Đối tượng</th>
                                    <th scope="col">Môn thi</th>
                                    <th scope="col">Điểm đạt</th>
                                    <th scope="col">Điểm khá</th>
                                    <th scope="col">Điểm giỏi</th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, index) in listLuat.data" :key="list.id" :class="list.id == id_luat? 'tractive':''">
                                    <th scope="row">{{index+1}}</th>
                                    <td>{{ list.min_age }} - {{ list.max_age }}</td>
                                    <td>{{list.gioi_tinh==0?'Nam cán bộ':list.gioi_tinh==1?'Nam cảnh vệ':list.gioi_tinh==2?'Nữ cán bộ':''}}</td>
                                    <td>{{list.monthi.ten_mon_thi}}</td>
                                    <td>{{list.dat}}</td>
                                    <td>{{list.kha}}</td>
                                    <td>{{list.gioi}}</td>
                                    <td width="20%">
                                        <button class="btn btn-warning" @click="editLuat(list.id)">Sửa</button>
                                        <button class="btn btn-danger" @click="deletedLuat(list.id)">Xóa</button>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
						<!-- end -->
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
            // data for modal luat
            modeLuat:'add',
            id_quy_tac:'',
            id_luat:'',
            min_age:'',
            max_age:'',
            gioi_tinh:'',
            mon_thi:'',
            dat:'',
            kha:'',
            gioi:'',
            listLuat:'',
        }
    },
    computed:{
        listData(){
            return this.$store.state.listQuytac;
        },
        listMonthi(){
            return this.$store.state.listMonthi;
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
        },
        // xử lý dữ liệu modal luật 
        loadDataModal(id){
            if(this.id_quy_tac != id){this.id_quy_tac = id;}
            axios.get('/chiensykhoe/listLuat/'+id)
            .then(response=>{
                this.listLuat = response.data;
            })
            .catch(error=>{

            })
        },
        addLuat(){
            let data = new FormData();
            data.append('id_quy_tac', this.id_quy_tac);
            data.append('min_age', this.min_age);
            data.append('max_age', this.max_age);
            data.append('gioi_tinh', this.gioi_tinh);
            data.append('mon_thi', this.mon_thi);
            data.append('dat', this.dat);
            data.append('kha', this.kha);
            data.append('gioi', this.gioi);
            axios.post('/chiensykhoe/addLuat', data)
            .then(response=>{
                this.mon_thi="";
                this.dat="";
                this.kha="";
                this.gioi="";
                this.loadDataModal(this.id_quy_tac);
            })
            .catch(err=>{
                
            })
        },
        editLuat(id){
            this.modeLuat = 'edit';
            this.id_luat = id;
            axios.get('/chiensykhoe/editLuat/'+id)
            .then(response=>{
                this.min_age = response.data.min_age;
                this.max_age = response.data.max_age;
                this.gioi_tinh = response.data.gioi_tinh;
                this.mon_thi = response.data.mon_thi;
                this.dat = response.data.dat;
                this.kha = response.data.kha;
                this.gioi = response.data.gioi;
            })
            .catch(error=>{

            })
        },
        updateLuat(id){
            let data = new FormData();
            data.append('id_quy_tac', this.id_quy_tac);
            data.append('min_age', this.min_age);
            data.append('max_age', this.max_age);
            data.append('gioi_tinh', this.gioi_tinh);
            data.append('mon_thi', this.mon_thi);
            data.append('dat', this.dat);
            data.append('kha', this.kha);
            data.append('gioi', this.gioi);
            axios.post('/chiensykhoe/updateLuat/'+id, data)
            .then(response=>{
                this.loadDataModal(this.id_quy_tac);
                swal('update thành công !');
            })
            .catch(err=>{
                
            })
        },
        deletedLuat(id){
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
                    axios.get('/chiensykhoe/deleteLuat/'+id)
                    .then(res=>{
                        this.loadDataModal(this.id_quy_tac);
                        swal('Xóa Thành công !');
                    })
                    .catch(e=>{
                        swal('Bạn không có quyền thực hiện thao tác này !');
                    })
                }
            })
        },
        backLuat(){
            this.modeLuat = 'add';
            this.id_luat = '';
            this.min_age = '';
                this.max_age = '';
                this.gioi_tinh = '';
                this.mon_thi = '';
                this.dat = '';
                this.kha = '';
                this.gioi = '';
        },
    },
    mounted(){
        if(this.$store.state.listQuytac==''){
            this.$store.dispatch('acListQuytac');
        }
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

