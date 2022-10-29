<template>
	<div>
		<content-header :tieude="tieude" :link="link"></content-header>
        <section class="content">
    		<div class="container-fluid">
				<div class="row">
					<div class="col-md-10 main">
						<!-- form -->
						<form method="post" @submit.prevent="add">

							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tên đơn vị</label>
									<input type="text" class="form-control form-control-sm" 
										v-model="ten_don_vi" 
										:class="{'is-invalid' : (error && error.ten_don_vi)}" >
									<p class="thongbao" v-if="error && error.ten_don_vi">{{ error.ten_don_vi[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Ký hiệu</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.ky_hieu)}" 
										v-model="ky_hieu">
									<p class="thongbao" v-if="error && error.ky_hieu">{{ error.ky_hieu[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Thứ tự</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.thu_tu)}" 
										v-model="thu_tu">
									<p class="thongbao" v-if="error && error.thu_tu">{{ error.thu_tu[0]}}</p>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-5">
									<label class="col-form-label col-form-label-sm">Khối</label>
									<select class="form-control form-control-sm" 
										v-model="khoi">
										<!-- <option value="0">Chọn Khối</option> -->
										<option v-for="list in listKhoi" :key="list.id" :value="list.id">{{list.ten_khoi}}</option>
									</select>
								</div>
								
							</div>
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-primary btn-sm">Thêm đơn vị</button>
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
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10 list">
					<list :listData="listData" @deleted='loadData'></list>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-md-10 trang justify-content-end">
                <paginate :last_pages="listData.last_page" @loadData='loadData'></paginate>
            </div>
        </div>
	</div>

</template>

<script>
// import các components
import contentHeader from '../content_header'
import list from './list.vue'
import paginate from './page.vue'
export default {
	data(){
		return{
			tieude:'THÊM ĐƠN VỊ',
			link:'Thêm',
			ten_don_vi:'',
			ky_hieu:'',
			thu_tu:'',
			khoi:1,
			listData:'',
			listKhoi:'',
			error:'',
			message:'',
		}
	},
	computed:{
		page(){return this.$store.state.pageDonvi;}
	},
	components:{
		contentHeader, list, paginate
	},
	methods:{
		add(){
			let data = new FormData;
			data.append('ten_don_vi',this.ten_don_vi); 
			data.append('ky_hieu',this.ky_hieu); 
			data.append('thu_tu',this.thu_tu); 
			data.append('khoi',this.khoi); 
			axios.post('/chiensykhoe/admin/addDonvi', data)
			.then(response=>{
				this.loadData();
				this.ten_don_vi = '';
				this.ky_hieu = '';
				this.thu_tu = '';
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
				axios.get('/chiensykhoe/admin/listDonvi?page=' + page)
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
		loadKhoi(){
			var n=0;
			var load = ()=>{
				axios.get('/chiensykhoe/listKhoi')
				.then(response=>{
					this.listKhoi = response.data;
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
		this.loadKhoi();
	}
}
</script>

<style scoped>

</style>