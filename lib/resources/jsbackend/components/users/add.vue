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
									<label class="col-form-label col-form-label-sm">Tài khoản</label>
									<input type="text" class="form-control form-control-sm" 
										v-model="username" 
										:class="{'is-invalid' : (error && error.name)}" >
									<p class="thongbao" v-if="error && error.name">{{ error.name[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Tên hiển thị</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.display_name)}" 
										v-model="fullname">
									<p class="thongbao" v-if="error && error.display_name">{{ error.display_name[0]}}</p>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label col-form-label-sm">Mật khẩu</label>
									<input type="password" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.key_code)}" 
										v-model="password">
									<p class="thongbao" v-if="error && error.key_code">{{ error.key_code[0]}}</p>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-5">
									<label class="col-form-label col-form-label-sm">Phân quyền</label>
									<select class="form-control form-control-sm" 
										v-model="parent_id">
										<option value="0">Chọn chức năng cha</option>
										<option v-for="listCha in listChucNangCha" :key="listCha.id" :value="listCha.id">{{listCha.name}}</option>
									</select>
								</div>
								
							</div>
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-primary btn-sm">Thêm chức năng</button>
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
					<list :listData="listChucNang" @deleted='loadData'></list>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-md-10 trang justify-content-end">
                <paginate :last_pages="listChucNang.last_page" @loadData='loadData'></paginate>
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
			tieude:'THÊM TÀI KHOẢN',
			link:'Thêm',
			username:'',
			fullname:'',
			password:'',
			error:'',
			listData:'',
			chuc_nang_cha:'',
		}
	},
	computed:{
		listChucNangCha(){
			return this.$store.state.listChucNangCha;
		},
		listChucNang(){
			return this.$store.state.listChucNang;
		},
		page(){
			return this.$store.state.pageChucNang;
		}
	},
	components:{
		contentHeader, list, paginate
	},
	methods:{
		add(){
			let data = new FormData;
			data.append('name',this.name); 
			data.append('display_name',this.display_name); 
			data.append('key_code',this.key_code); 
			data.append('parent_id',this.parent_id); 
			axios.post('/chiensykhoe/admin/addChucNang', data)
			.then(response=>{
				this.$store.dispatch('acListChucNangCha');
				this.$store.dispatch('acListChucNang');
				this.name = '';
				this.display_name = '';
				this.key_code = '';
				this.error = '';
			})
			.catch(error=>{
				this.error = error.response.data.errors;
				// console.log(error.response);
			});
		},
		loadData(){
			this.$store.dispatch('acListChucNang',this.page);
		}
	},
	mounted(){
		this.$store.dispatch('acListChucNangCha');
		if(this.$store.state.listChucNang == ''){this.$store.dispatch('acListChucNang',1);}
	}
}
</script>

<style scoped>

</style>