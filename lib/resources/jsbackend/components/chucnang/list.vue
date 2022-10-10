<template>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên chức năng</th>
                <th>Tên đầy đủ</th>
                <th>Key Code</th>
                <th>Chức năng cha</th>
                <th>Cập nhật</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(list, index) in listData.data" :key="list.id" :class="list.id == idEdit? 'tractive':''">
                <td>{{index + 1}}</td>
                <td>{{list.name}}</td>
                <td>{{list.display_name}}</td>
                <td>{{list.key_code}}</td>
                <td v-if="list.parent_permission != null">{{list.parent_permission.name}}</td>
                <td v-else></td>
                <td>
                    <router-link class="btn btn-primary btn-sm" :to="`/chucnang/edit/${list.id}`" @click.native="loadDataById(list.id)">Sửa</router-link>
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
    props:[
        'listData'
    ],
    computed:{
        // listPermissionOfUser(){
		// 	return this.$store.state.listPermissionOfUser;
		// },
    },
    methods:{
        loadDataById(id){
            this.idEdit = id;
            this.$emit('loadDataById', id);
        },
        deleteData(id){
            axios.get('/chiensykhoe/admin/deleteChucNang/'+id)
            .then(res=>{
                this.$emit('deleted');
                swal('Xóa Thành công !');
            })
        },
		// ktquyen(key_code){
		// 	for(var i in this.listPermissionOfUser){
		// 		if(this.listPermissionOfUser[i].key_code == key_code){
		// 			return true;
		// 		}
		// 	}
		// 	return false;
		// }
    },
    mounted(){
        this.idEdit = this.$route.params.id;
    },
}
</script>

<style>
.list{
    margin:0 auto;
    margin-top:30px;
    padding:0;
}
.trang{
    margin:0 auto;
    padding:0;
}
.tractive, .tractive:hover{
    background:rgb(171, 204, 178);
}
</style>