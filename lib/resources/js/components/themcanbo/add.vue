<template>
    <div>
        <div class="danh-sach">
            <div class="title">THÊM CÁN BỘ VÀO DANH SÁCH</div>
            <div class="title">{{tenDanhsach}}</div>
        </div>
        <div class="danh-sach">
            <div class="danh-sach__title">TÌM KIẾM CÁN BỘ</div>
                <div class="danh-sach__content">
                    <form method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Họ tên</label>
                                <input type="text" class="form-control" v-model="ho_ten">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Đơn vị</label>
                                <vue-select v-model="don_vi" :options="listDonvi" :reduce="(e)=>{return e.id}" label="ten_don_vi"></vue-select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button class="btn btn-info" @click.prevent="search">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
        <!-- list danh sach tìm kiếm -->
        <div class="danh-sach" v-if="listSearch!=''">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Năm sinh</th>
                    <th scope="col">Đối tượng</th>
                    <th scope="col">Đơn vị</th>
                    <th scope="col"><input type="checkbox" id="checkid" @change="checkAll" v-model="check_all"> <label class="checkall" for="checkid">Chọn hết</label></th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list, index) in listSearch" :key="list.id">
                    <th scope="row">{{index+1}}</th>
                    <td>{{ list.ho_ten}}</td>
                    <td>{{ list.nam_sinh }}</td>
                    <td>{{ list.gioi_tinh==0?'Nam cán bộ':list.gioi_tinh==1?'Nam Cảnh vệ':list.gioi_tinh==2?'Nữ cán bộ':'' }}</td>
                    <td>{{ list.ten_don_vi}}</td>
                    <td width="10%">
                        <input type="checkbox" :value="list.id" v-model="mangcanbo" @change="checkModule()">
                    </td>
                    <td width="10%">
                        <a :href="'/chiensykhoe/admin#/canbo/edit/'+list.id" target="blank"><button class="btn btn-success">Sửa Cán bộ</button></a>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div> 
        <div class="col-md-12" v-if="listSearch!=''"><button class="btn btn-info" @click="addCanbo">Thêm vào Danh sách</button></div>
        <!-- end -->
        <!-- List cán bộ trong Danh sách -->
        <div class="danh-sach">
            <div class="title">DANH SÁCH CÁN BỘ KIỂM TRA</div>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Năm sinh</th>
                    <th scope="col">Đối tượng</th>
                    <th scope="col">Đơn vị</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list, index) in listCanboOfDanhsach" :key="list.id">
                    <th scope="row">{{index+1}}</th>
                    <td>{{ list.ho_ten}}</td>
                    <td>{{ list.nam_sinh }}</td>
                    <td>{{ list.gioi_tinh==0?'Nam cán bộ':list.gioi_tinh==1?'Nam Cảnh vệ':list.gioi_tinh==2?'Nữ cán bộ':'' }}</td>
                    <td>{{ list.donvi.ten_don_vi}}</td>
                    <td width="10%">
                        <button class="btn btn-danger" @click="deleted(list.id)">Xóa </button>
                    </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <router-link :to="'/danhsach'"><button class="btn btn-warning">Quay lại</button></router-link>
            </div>
        </div> 
        <!-- end -->
  </div>
</template>

<script>
import vueSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
export default {
    data(){
        return {
            // load data
            idDanhsach:'',
            tenDanhsach:'',
            listCanboOfDanhsach:'',
            // tìm kiếm
            ho_ten:'',
            don_vi:1,
            listSearch:'',
            mangcanbo:[],
            check_all:false,
            // 
        }
    },
    computed:{
        listDonvi(){
            return this.$store.state.listDonvi;
        }
    },
    methods:{
        tenDanhSach(){
            var n = 0;
            var load = ()=>{
                axios.get('/chiensykhoe/editDanhsach/'+this.$route.params.id)
                .then(response=>{
                    this.tenDanhsach = response.data.ten_danh_sach;
                })
                .catch(eror=>{
                    n+=1;
                    if(n<3){load();}
                });
            }
            load();
        },
        canboOfDanhsach(){
            var n = 0;
            var load = ()=>{
                axios.get('/chiensykhoe/listCanboOfDanhsach/'+this.$route.params.id)
                .then(response=>{
                    this.listCanboOfDanhsach = response.data[0].canbo;
                    // console.log(response.data[0].canbo);
                })
                .catch(eror=>{
                    n+=1;
                    if(n<3){load();}
                });
            }
            load();      
        },
        search(){
            let data = new FormData;
            data.append('ho_ten', this.ho_ten);
            data.append('don_vi', this.don_vi);
            axios.post('/chiensykhoe/searchCanbo', data)
            .then(response=>{
                this.listSearch = response.data;
                this.check_all = false;
            })
            .catch(error=>{

            });
        },
        checkAll(){
            if(this.check_all==true){
                if(this.listSearch != ""){
                    this.listSearch.map(e=>{
                        this.mangcanbo.push(e.id);
                    })
                }
            }else{
                this.mangcanbo = [];
            }
        },
        checkModule(){
            if(event.target.checked == true){
                if(this.listSearch.length == this.mangcanbo.length){
                    this.check_all = true;
                }
            }else{
                this.check_all = false;
            };
        },
        addCanbo(){
            let data = new FormData;
            data.append('idDanhsach', this.idDanhsach);
            for(var i in this.mangcanbo){
                data.append('mangcanbo[]', this.mangcanbo[i]);
            }
            axios.post('/chiensykhoe/addCanboToDanhsach',data)
            .then(response=>{
                this.canboOfDanhsach();
            })
            .catch(error=>{

            })
        },
        deleted(id){
            swal('Bạn muốn loại người này khỏi danh sách kiểm tra ???',{
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
                    axios.get('/chiensykhoe/deletedCanboOfDanhsach/'+id)
                    .then(res=>{
                        this.canboOfDanhsach();
                        swal('Xóa thành công !');
                    })
                    .catch(e=>{
                        swal('Bạn không có quyền thực hiện thao tác này !');
                    })
                }
            })
        }
    },
    mounted(){
        this.idDanhsach = this.$route.params.id;
        this.tenDanhSach();
        if(this.$store.state.listDonvi == ''){
            this.$store.dispatch('acListDonvi');
        }
        this.canboOfDanhsach();
    },
    components:{
        vueSelect,
    }
}
</script>

<style lang="scss" scoped>
    .title{
        font-size: 1.2em;
        font-weight: bold;
        margin-top:15px;
    }
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
    label.checkall{
        cursor: pointer;
        padding-left:5px;
    }
    checkbox{
        background:green;
    }
</style>>
<style>
.vs__dropdown-toggle{
        padding:0 0 5px;
    }

</style>

