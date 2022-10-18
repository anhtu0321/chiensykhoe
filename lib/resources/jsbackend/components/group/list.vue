<template>
  <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên nhóm quyền</th>
                <th>Tên đầy đủ</th>
                <th>Cập nhật</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(list, index) in listData.data" :key="list.id" :class="list.id == idEdit? 'tractive':''">
                <td>{{index + 1}}</td>
                <td>{{list.name}}</td>
                <td>{{list.display_name}}</td>
                <td>
                    <router-link class="btn btn-primary btn-sm" :to="`/role/edit/${list.id}`" @click.native="loadDataById(list.id)">Sửa</router-link>
                    <button class="btn btn-danger btn-sm" @click.prevent="deleteData(list.id)" >Xóa</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    data(){
        return{
            idEdit:'',
        }
    },
    props:['listData'],
    methods:{
        loadDataById(id){
            this.idEdit = this.$route.params.id;
            this.$emit('loadDataById', id);
        },
        deleteData(id){
            swal('Bạn chắc chắn muốn xóa nó không ???',{
                buttons:{
                    cancel:'Hủy bỏ',
                    delete:'Xóa',
                }
            })
            .then((value)=>{
                if(value =='cancel'){
                    swal('Bạn đã hủy lệnh !');
                }
                if(value == 'delete'){
                    axios.get('/chiensykhoe/admin/deleteRole/'+ id)
                    .then((response)=> {
                        this.$emit('deleted',id);
                        swal('Xóa Thành công !');
                    })
                }
            })
            
        }
    },
    mounted(){
        this.idEdit = this.$route.params.id;
    },
}
</script>

<style>

</style>