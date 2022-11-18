<template>
    <div class="danh-sach">
        <div class="danh-sach__title">THÊM DANH SÁCH KIỂM TRA</div>
        <div class="danh-sach__content">
            <form method="post">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Tên danh sách kiểm tra</label>
                        <input type="text" class="form-control" v-model="ten_danh_sach">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Năm kiểm tra</label>
                        <input type="text" class="form-control" v-model="nam">
                    </div>
                     <div class="form-group col-md-8">
                        <label for="">Môn thi</label>
                        <vue-select multiple v-model="mon_thi" :options="listMonthi.data" :reduce="e=>{return e.id}" label="ten_mon_thi"></vue-select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Quy tắc xếp loại</label>
                        <select class="form-control" v-model="quy_tac" >
                            <option v-for="list in listQuytac.data" :key="list.id" :value="list.id">{{list.ten_quy_tac}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12" v-if="mode == 'add'">
                        <button class="btn btn-info" @click.prevent="add">Thêm danh sách</button>
                    </div>
                    <div class="form-group col-md-12" v-if="mode == 'edit'">
                        <button class="btn btn-info" @click.prevent="update">Sửa danh sách</button>
                        <button class="btn btn-warning" @click.prevent="back">Quay lại</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- list danh sach -->
        <div class="list">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên danh sách</th>
                    <th scope="col">Năm kiểm tra</th>
                    <th scope="col">Quy tắc</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list, index) in listDanhsach.data" :key="list.id" :class="list.id == idEdit? 'tractive':''">
                    <th scope="row">{{index+1}}</th>
                    <td>{{ list.ten_danh_sach }}</td>
                    <td>{{list.nam}}</td>
                    <td>{{list.quytac.ten_quy_tac}}</td>
                    <td width="20%">
                        <router-link :to="`/themcanbo/${list.id}`"><button class="btn btn-success">Thêm cán bộ</button></router-link>
                        <button class="btn btn-warning" @click="edit(list.id)">Sửa</button>
                        <button class="btn btn-danger" @click="deleted(list.id)">Xóa</button>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- end -->
        <!-- Phân trang -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item" @click.prevent="prev()"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item" :class="{'active': currentPage==page}" @click.prevent="setPage(page)" v-for="page in pagesNumber" :key="page"><a class="page-link" href="#">{{ page }}</a></li>
                <li class="page-item" @click.prevent="next()"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
        <!-- end -->
    </div>
</template>

<script>
import vueSelect from 'vue-select';

export default {
    data(){
        return {
            ten_danh_sach:'',
            nam:'',
            mon_thi:[],
            quy_tac:0,
            listDanhsach:'',
            idEdit:'',
            mode:'add',
            // phân trang
            last_pages:'',
            currentPage: 1,
			offset: 4,
			from:1,
			to:1,
        }
    },
    computed:{
        listQuytac(){
            return this.$store.state.listQuytac;
        },
        listMonthi(){
            return this.$store.state.listMonthi;
        },
        pagesNumber() {
            if(this.last_pages == null){return [];}
            if(this.last_pages<=this.offset*2+1){
                this.from = 1;
                this.to = this.last_pages;
            }else{
                if(this.currentPage <= this.offset){
                    this.from = 1;
                    this.to = 1 + this.offset*2;
                    if(this.to > this.last_pages){
                        this.to = this.last_pages;
                    }
                }
                if((this.currentPage> this.offset) && (this.currentPage <= this.last_pages - this.offset)){
                    this.from = this.currentPage - this.offset;
                    this.to = this.currentPage + this.offset;
                }
                if(this.currentPage >this.last_pages - this.offset){
                    this.from = this.last_pages - this.offset*2;
                    this.to = this.last_pages;
                }
            }
            var pagesArray = [];
            for (var i=this.from; i <= this.to; i++) {
                pagesArray.push(i);
            }
            return pagesArray;
        },
    },
    methods:{
        add(){
            let data = new FormData();
            data.append('ten_danh_sach', this.ten_danh_sach);
            data.append('nam', this.nam);
            data.append('quy_tac', this.quy_tac);
            for(let i in this.mon_thi){
                data.append('mon_thi[]', this.mon_thi[i]);
            }
            axios.post('/chiensykhoe/addDanhsach', data)
            .then(response=>{
                this.ten_danh_sach="";
                this.nam="";
                this.mon_thi=[];
                this.quy_tac=0;
                this.loadListDanhsach();
            })
            .catch(err=>{
                
            })
        },
        edit(id){
            this.mode='edit';
            this.idEdit = id;
            axios.get('/chiensykhoe/editDanhsach/'+id)
            .then(response=>{
                this.ten_danh_sach = response.data.ten_danh_sach;
                this.nam = response.data.nam;
                this.mon_thi = response.data.monthi;
                this.quy_tac = response.data.quy_tac;
            })
        },
        update(){
            let data = new FormData();
            data.append('ten_danh_sach', this.ten_danh_sach);
            data.append('nam', this.nam);
            for(let i in this.mon_thi){
                data.append('mon_thi[]', this.mon_thi[i]);
            }
            data.append('quy_tac', this.quy_tac);
            axios.post('/chiensykhoe/updateDanhsach/'+this.idEdit, data)
            .then(response=>{
                this.loadListDanhsach();
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
                    axios.get('/chiensykhoe/deleteDanhsach/'+id)
                    .then(res=>{
                        this.loadListDanhsach();
                        swal('Xóa Thành công !');
                    })
                    .catch(e=>{
                        swal('Bạn không có quyền thực hiện thao tác này !');
                    })
                }
            })
        },
        back(){
            this.mode="add";
            this.idEdit='';
            this.ten_danh_sach='';
            this.nam='';
            this.mon_thi=[];
            this.quy_tac='';
        },
        loadListDanhsach(page){
            this.currentPage = page
            var n=0;
            var load = ()=>{
                axios.get('/chiensykhoe/listDanhsach?page='+this.page)
                .then(response=>{
                    this.listDanhsach = response.data;
                    this.last_pages = response.data.last_page;
                })
                .catch(error=>{
                    n+=1;
                    if(n<3){
                        load();
                    }
                })
            }
            load();
        },
        // phân trang
        setPage(newPage){
			this.currentPage = newPage;
			this.loadListDanhsach(newPage);
		},
		prev(){
			if(this.currentPage > 1){
				this.currentPage--;
				this.loadListDanhsach(this.currentPage);
			}
		},
		next(){
			if(this.currentPage < this.last_pages){
				this.currentPage++;
				this.loadListDanhsach(this.currentPage);
			}
		}
    },
    components:{vueSelect,},
    mounted(){
        if(this.$store.state.listQuytac==""){
            this.$store.dispatch('acListQuytac');
        }
        if(this.$store.state.listMonthi==""){
            this.$store.dispatch('acListMonthi');
        }
        this.loadListDanhsach(1);
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
</style>>

