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
									<label class="col-form-label col-form-label-sm">Giới tính</label>
									<select class="form-control form-control-sm" v-model="gioi_tinh">
										<option value="0">Nam</option>
										<option value="1">Nữ</option>
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
								<button type="submit" class="btn btn-primary btn-sm">Thêm Cán bộ</button>
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
					<list :listData="listData" @deleted='loadData'></list>
				</div>
				<div class="col-md-12 trang justify-content-end">
					<paginate :last_pages="listData.last_page" @loadData='loadData'></paginate>
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
			tieude:'THÊM CÁN BỘ',
			link:'Thêm',
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
		page(){return this.$store.state.pageCanbo;}
	},
	components:{
		contentHeader, list, paginate, vSelect
	},
	methods:{
		add(){
			let data = new FormData;
			data.append('ho_ten',this.ho_ten); 
			data.append('nam_sinh',this.nam_sinh); 
			data.append('gioi_tinh',this.gioi_tinh); 
			data.append('cap_bac',this.cap_bac); 
			data.append('chuc_vu',this.chuc_vu); 
			data.append('don_vi',this.don_vi); 
			axios.post('/chiensykhoe/admin/addCanbo', data)
			.then(response=>{
				this.loadData();
				this.ho_ten = '';
				this.nam_sinh = '';
				this.error = '';
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
		}
	},
	mounted(){
		this.loadData();
		this.loadCapbac();
		this.loadChucvu();
		this.loadDonvi();
	}
}
</script>

<style>
.vs--single{
	padding: 0;
	margin:0;
	height: calc(1.8125rem + 2px);
	font-size: 0.875rem;
	line-height: 1.5;
	border-radius: 0.2rem;
}
</style>