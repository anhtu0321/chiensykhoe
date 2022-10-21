<template>
	<div>
		<content-header :tieude="tieude" :link="link"></content-header>
        <section class="content">
    		<div class="container">
				<div class="row">
					<div class="col-md-12 main">
						<!-- form -->
						<form method="post" @submit.prevent="edit">

							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tài khoản</label>
									<input type="text" class="form-control form-control-sm" 
										v-model="username" 
										:class="{'is-invalid' : (error && error.username)}" >
									<p class="thongbao" v-if="error && error.name">{{ error.name[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tên hiển thị</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.fullname)}" 
										v-model="fullname">
									<p class="thongbao" v-if="error && error.display_name">{{ error.display_name[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Mật khẩu</label>
									<input type="password" class="form-control form-control-sm" 
										placeholder="Không đổi mật khẩu thì để trống !"
										:class="{'is-invalid' : (error && error.password)}" 
										v-model="password">
									<p class="thongbao" v-if="error && error.key_code">{{ error.key_code[0]}}</p>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-5">
									<label class="col-form-label col-form-label-sm">Phân quyền</label>
									<v-select multiple v-model="roles" :options="listRole.data" :reduce="(role)=>{return role.id}" label="name"></v-select>
								</div>
								
							</div>
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-success btn-sm" >Sửa Tài khoản</button>
								<router-link to="/users" class="btn btn-warning btn-sm">Quay lại</router-link>
							</div>

					</form>
					<!-- end form -->
					</div>
				</div>
			</div>
  		</section>
		<div class="container">
			<div class="row">
				<div class="col-md-12 list">
					<list :listData="listUser" @deleted='loadData' @loadDataById='getDataById'></list>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 trang justify-content-end">
					<paginate :last_pages="listUser.last_page" @loadData='loadData'></paginate>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
// import các components
import contentHeader from '../content_header'
import list from './list.vue'
import paginate from './page.vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
export default {
	data(){
		return{
			tieude:'SỬA TÀI KHOẢN',
			link:'Sửa',
			username:'',
			fullname:'',
			password:'',
			roles:[],
			error:'',
			listRole:'',
		}
	},
	computed:{
		listUser(){
			return this.$store.state.listUser;
		},
		page(){
			return this.$store.state.pageUser;
		}
	},
	components:{
		contentHeader, list, paginate, vSelect
	},
	methods:{
		edit(){
			let data = new FormData;
			data.append('username',this.username); 
			data.append('fullname',this.fullname); 
			data.append('password',this.password);
			for(var i in this.roles){
				data.append('roles[]',this.roles[i]);
			} 
			axios.post('/chiensykhoe/admin/editUser/'+this.$route.params.id, data)
			.then(response=>{
				this.$store.dispatch('acListUser');
				swal('Cập nhật thành công !');
			})
			.catch(error=>{
				this.error = error.response.data.errors;
				// console.log(error.response);
			});
		},
		loadData(){
			this.$store.dispatch('acListChucNang',this.page);
		},
		loadListRole(){
			var n=0;
			
			var load = ()=>{
				axios.get('/chiensykhoe/admin/listRoleFull')
				.then(response=>{
					this.listRole = response;
				})
				.catch((e)=>{
					n+=1;
					if(n<5){load();}
				})
			}
			load();
		},
		getDataById(id){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/admin/getUser/'+id)
				.then(response=>{
					this.username = response.data[0].username;
					this.fullname = response.data[0].fullname;
					this.roles = response.data[0].role.map(e=>{return e.id});
				})
				.catch((e)=>{
					n+=1;
					if(n<5){load();}
				})
			}
			load();
		}
	},
	mounted(){
		this.getDataById(this.$route.params.id);
		this.loadListRole();
		if(this.$store.state.listUser == ''){this.$store.dispatch('acListUser',1);}
	}
}
</script>

<style scoped>
.select2-selection__choice__display{
	background: rgb(43, 92, 95);
	padding:3px;
	margin-left:5px;
}
</style>