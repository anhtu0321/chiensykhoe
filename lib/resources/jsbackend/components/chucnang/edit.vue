<template>
	<div>
		<content-header :tieude="tieude" :link="link"></content-header>
        <section class="content">
    		<div class="container">
				<div class="row">
					<div class="col-md-12 main">
						<form method="post" @submit.prevent="edit">
							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tên chức năng</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.name)}" 
										v-model="name">
									<p class="thongbao" v-if="error && error.name">{{ error.name[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tên Đầy đủ</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.display_name)}" 
										v-model="display_name">
									<p class="thongbao" v-if="error && error.display_name">{{ error.display_name[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Key Code</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.key_code)}" 
										v-model="key_code">
									<p class="thongbao" v-if="error && error.key_code">{{ error.key_code[0]}}</p>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-5">
									<label class="col-form-label col-form-label-sm">Chức năng cha</label>
									<select class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.parent_id)}" 
										v-model="parent_id">
										<option value="0">Chọn chức năng cha</option>
										<option v-for="listCha in chuc_nang_cha" :key="listCha.id" :value="listCha.id">{{listCha.name}}</option>
									</select>
									<p class="thongbao" v-if="error && error.parent_id">{{ error.parent_id[0]}}</p>
								</div>
								
							</div>
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-success btn-sm" >Sửa Chức năng</button>
								<router-link to="/chucnang" class="btn btn-warning btn-sm">Quay lại</router-link>
							</div>
							<div class="alert alert-warning col-md-12 text-center" v-if="message!=''">
									{{ message }}
							</div>
					</form>
					</div>
				</div>
			</div>
  		</section>
		<div class="container">
			<div class="row">
				<div class="col-md-12 list">
					<list @loadDataById='loadDataById' :listData='listData' @deleted="loadData()"></list>
				</div>
				<div class="col-md-12 trang justify-content-end">
					<paginate :last_pages="listData.last_page" @loadData="loadData"></paginate>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
// import các components
import contentHeader from '../content_header.vue'
import list from './list.vue'
import paginate from './page.vue'
export default {
	data(){
		return{
			tieude:'SỬA CHỨC NĂNG',
			link:'Sửa',
			name:'',
			display_name:'',
			key_code:'',
			parent_id:'',
			error:'',
			chuc_nang_cha:'',
			listData:'',
			message:'',
		}
	},
	computed:{
		// listPermissionOfUser(){
		// 	return this.$store.state.listPermissionOfUser;
		// },
		page(){
			return this.$store.state.pageChucNang;
		}
	},
	methods:{
		edit(){
			let data = new FormData;
			data.append('name', this.name);
			data.append('display_name', this.display_name);
			data.append('key_code', this.key_code);
			data.append('parent_id', this.parent_id);
			axios.post(`/chiensykhoe/admin/updateChucNang/${this.$route.params.id}`, data) //cach viet thu 2
			.then(response=>{
				this.loadData();
				this.listChucNangCha();
				swal("Cập nhật thành công !");
			})
			.catch(error=>{
				this.error = error.response.data.errors;
				if(error.response.data.errors == undefined){
					this.message = "Bạn không có quyền thực hiện thao tác này !";
				}
			});
		},
		listChucNangCha(){
			axios.get('/chiensykhoe/admin/listChucNangCha')
			.then(response=>{
				this.chuc_nang_cha = response.data;
			})
		},
		loadData(){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/admin/listChucNang?page='+this.page)
				.then(response=>{
					this.listData = response.data;
				})
				.catch(e=>{
					n+=1;
					console.log("error: load listChucNang");
					if(n<5){
						load();
					}
				})
			}
			load();
			
		},
		loadDataById(id){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/admin/getChucNang/'+id)
				.then(response=>{
					this.name = response.data[0].name;
					this.display_name = response.data[0].display_name;
					this.key_code = response.data[0].key_code;
					this.parent_id = response.data[0].parent_id;
				})
				.catch( e=>{
					n+=1;
					if(n<5){
						load();
					}
				})
			}
			load();
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
	components:{contentHeader, list, paginate},
	mounted(){
		this.loadData();
		this.listChucNangCha();
		this.loadDataById(this.$route.params.id);
	},
}
</script>

<style scoped>


</style>