<template>
    <div class="kiemtra">
        <div class="title">DANH SÁCH: {{this.ten_danh_sach}}</div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Năm sinh</th>
                    <th scope="col">Đối tượng/ giới tính</th>
                    <th scope="col">Đơn vị</th>
                    <th scope="col" width="40%">Kết quả</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list, index) in list_can_bo" :key="list.id">
                    <th scope="row">{{index+1}}</th>
                    <td>{{list.ho_ten}}</td>
                    <td>{{list.nam_sinh}}</td>
                    <td>{{list.gioi_tinh==0?'Nam cán bộ':list.gioi_tinh==1?'Nam Cảnh vệ':list.gioi_tinh==2?'Nữ cán bộ':'' }}</td>
                    <td>{{list.ten_don_vi}}</td>
                    <td>
                        <div>
                            <form method="post">
                                
                                <div class="form-row align-items-center" v-for="listMonthi in list.ketqua" :key="listMonthi.id">
                                    <div class="col-md-3">
                                        <label> {{ listMonthi.ten_mon_thi }}: </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group mb-1">
                                            <input type="text" class="form-control" :id="listMonthi.id_monthi+'_'+list.id_canbo" :value="listMonthi.diem">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check mb-1" v-html="listMonthi.xeploai">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-row align-items-center">
                                    <button class="btn btn-info" @click.prevent="save(list.id_canbo)">Lưu kết quả</button>
                                </div>
                               
                            </form>
                        </div>
                        
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data(){
        return{
            ten_danh_sach:'',
            list_can_bo:[],
            list_mon_thi:[],
        }
    },
    methods:{
        tenDanhSach(){
            var n = 0;
            var load = ()=>{
                axios.get('/chiensykhoe/editDanhsach/'+this.$route.params.id)
                .then(response=>{
                    this.ten_danh_sach = response.data.ten_danh_sach;
                    this.list_mon_thi = response.data.monthi;
                })
                .catch(eror=>{
                    n+=1;
                    if(n<3){load();}
                });
            }
            load();
        },
        loadCanboOfDs(){
            var n = 0;
            var load = ()=>{
                axios.get('/chiensykhoe/listCanboKiemtra/'+this.$route.params.id)
                .then(response=>{
                    this.list_can_bo = response.data;
                    // console.log(response.data);
                })
                .catch(eror=>{
                    n+=1;
                    if(n<3){load();}
                });
            }
            load();
        },
        save(id){
            let data = new FormData;
            data.append('id_canbo', id);
            data.append('id_danhsach', this.$route.params.id);
            for( var i in this.list_mon_thi){
                var idInput = this.list_mon_thi[i].id+'_'+id;
                var value = document.getElementById(idInput).value;
                data.append('ketqua[]',[this.list_mon_thi[i].id, value]) 
            }
            axios.post('/chiensykhoe/saveKetqua',data)
            .then(response=>{
                this.loadCanboOfDs();
            })
            .catch(err=>{

            })
        }
    },
    
    mounted(){
        this.tenDanhSach();
        this.loadCanboOfDs();
    }
}
</script>

<style>
.truot{
    font-weight: bold;
    color:grey;
}
.dat{
    font-weight: bold;
    color:rgb(11, 129, 31);
}
.kha{
    font-weight: bold;
    color:rgb(15, 4, 175);
}
.gioi{
    font-weight: bold;
    color:rgba(219, 120, 6, 0.89);
}
</style>>

