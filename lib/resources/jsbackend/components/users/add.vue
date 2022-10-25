<template>
	<div>
		<content-header :tieude="tieude" :link="link"></content-header>
        <section class="content">
    		<div class="container">
				<div class="row">
					<div class="col-md-12 main">
						<!-- form -->
						<form method="post" @submit.prevent="add">

							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tài khoản</label>
									<input type="text" class="form-control form-control-sm" 
										v-model="username" 
										:class="{'is-invalid' : (error && error.username)}" >
									<p class="thongbao" v-if="error && error.username">{{ error.username[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tên hiển thị</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.fullname)}" 
										v-model="fullname">
									<p class="thongbao" v-if="error && error.fullname">{{ error.fullname[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Mật khẩu</label>
									<input type="password" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.password)}" 
										v-model="password">
									<p class="thongbao" v-if="error && error.password">{{ error.password[0]}}</p>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-5">
									<label class="col-form-label col-form-label-sm">Phân quyền</label>
									<v-select multiple v-model="roles" :options="listRole.data" :reduce="(role)=>{return role.id}" label="name"></v-select>
								</div>
							</div>
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-primary btn-sm">Thêm Tài khoản</button>
							</div>
							<div class="alert alert-warning col-md-12 text-center" v-if="message!=''">
									{{ message }}
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
					<list :listData="listUser" @deleted='loadData'></list>
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
			tieude:'THÊM TÀI KHOẢN',
			link:'Thêm',
			username:'',
			fullname:'',
			password:'',
			roles:[],
			error:'',
			listRole:'',
			message:'',
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
		add(){
			let data = new FormData;
			data.append('username',this.username); 
			data.append('fullname',this.fullname); 
			data.append('password',this.password);
			for(var i in this.roles){
				data.append('roles[]',this.roles[i]);
			} 
			axios.post('/chiensykhoe/admin/addUser', data)
			.then(response=>{
				this.$store.dispatch('acListUser');
				this.username = '';
				this.fullname = '';
				this.password = '';
				this.error = '';
			})
			.catch(error=>{
				this.error = error.response.data.errors;
				if(error.response.data.errors == undefined){
					this.message = "Bạn không có quyền thực hiện thao tác này !";
				}
			});
		},
		loadData(){
			this.$store.dispatch('acListUser',this.page);
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
		}
	},
	mounted(){
		this.loadListRole();
		if(this.$store.state.listUser == ''){this.$store.dispatch('acListUser',this.page);}
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