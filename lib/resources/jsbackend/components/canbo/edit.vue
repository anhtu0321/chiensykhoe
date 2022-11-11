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
									<label class="col-form-label col-form-label-sm">Họ tên</label>
									<input type="text" class="form-control form-control-sm" 
										v-model="ho_ten" 
										:class="{'is-invalid' : (error && error.ho_ten)}" >
									<p class="thongbao" v-if="error && error.ho_ten">{{ error.ho_ten[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Năm sinh</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.nam_sinh)}" 
										v-model="nam_sinh">
									<p class="thongbao" v-if="error && error.nam_sinh">{{ error.nam_sinh[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Đối tượng/ Giới tính</label>
									<select class="form-control form-control-sm" v-model="gioi_tinh">
										<option value="0">Nam cán bộ</option>
										<option value="1">Nam Cảnh vệ</option>
										<option value="2">Nữ cán bộ</option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Cấp bậc</label>
									<select class="form-control form-control-sm" v-model="cap_bac">
										<option v-for="list in listCapbac" :key="list.id" :value="list.id">{{list.ten_cap_bac}}</option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Chức vụ</label>
									<select class="form-control form-control-sm" v-model="chuc_vu">
										<option v-for="list in listChucvu" :key="list.id" :value="list.id">{{list.ten_chuc_vu}}</option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Đơn vị</label>
									<v-select v-model="don_vi" :options="listDonvi" :reduce="(e)=>{return e.id}" label="ten_don_vi"></v-select>
								</div>
							</div>
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-success btn-sm" >Sửa Cán bộ</button>
								<router-link to="/canbo" class="btn btn-warning btn-sm">Quay lại</router-link>
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
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
export default {
	data(){
		return{
			tieude:'SỬA CÁN BỘ',
			link:'Sửa',
			ho_ten:'',
			nam_sinh:'',
			gioi_tinh:0,
			cap_bac:1,
			chuc_vu:1,
			don_vi:1,
			listCapbac:'',
			listChucvu:'',
			listDonvi:'',
			listData:'',
			error:'',
			message:'',
		}
	},
	computed:{
		page(){
			return this.$store.state.pageCanbo;
		}
	},
	methods:{
		edit(){
			let data = new FormData;
			data.append('ho_ten',this.ho_ten); 
			data.append('nam_sinh',this.nam_sinh); 
			data.append('gioi_tinh',this.gioi_tinh); 
			data.append('cap_bac',this.cap_bac); 
			data.append('chuc_vu',this.chuc_vu); 
			data.append('don_vi',this.don_vi); 
			axios.post(`/chiensykhoe/admin/editCanbo/${this.$route.params.id}`, data) //cach viet thu 2
			.then(response=>{
				this.loadData();
				this.error = '';
				swal("Cập nhật thành công !");
			})
			.catch(error=>{
				this.error = error.response.data.errors;
				if(error.response.data.errors == undefined){
					this.message = "Bạn không có quyền thực hiện thao tác này !";
				}
			});
		},
		loadData(page){
			var n = 0;
			var load = ()=>{
				if(page == undefined){page = this.page}
				axios.get('/chiensykhoe/admin/listCanbo?page=' + page)
				.then(response=>{
					this.listData = response.data;
				})
				.catch(e=>{
					n+=1;
					if(n<5){load();}
				})
			}
			load();
		},
		loadCapbac(){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/listCapbac')
				.then(response=>{
					this.listCapbac = response.data;
				})
				.catch(e=>{
					n+=1;
					if(n<5){load();}
				})
			}
			load();
		},
		loadChucvu(){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/listChucvu')
				.then(response=>{
					this.listChucvu = response.data;
				})
				.catch(e=>{
					n+=1;
					if(n<5){load();}
				})
			}
			load();
		},
		loadDonvi(){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/listDonvi')
				.then(response=>{
					this.listDonvi = response.data;
				})
				.catch(e=>{
					n+=1;
					if(n<5){load();}
				})
			}
			load();
		},
		loadDataById(id){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/admin/getCanbo/'+id)
				.then(response=>{
					this.ho_ten = response.data[0].ho_ten;
					this.nam_sinh = response.data[0].nam_sinh;
					this.gioi_tinh = response.data[0].gioi_tinh;
					this.cap_bac = response.data[0].cap_bac;
					this.chuc_vu = response.data[0].chuc_vu;
					this.don_vi = response.data[0].don_vi;
				})
				.catch( e=>{
					n+=1;
					if(n<5){load();}
				})
			}
			load();
		},
	},
	components:{contentHeader, list, paginate, vSelect},
	mounted(){
		this.loadData();
		this.loadCapbac();
		this.loadChucvu();
		this.loadDonvi();
		this.loadDataById(this.$route.params.id);
	},
}
</script>

<style scoped>


</style>