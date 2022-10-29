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
									<label class="col-form-label col-form-label-sm">Tên chức năng</label>
									<input type="text" class="form-control form-control-sm" 
										v-model="name" 
										:class="{'is-invalid' : (error && error.name)}" >
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
										v-model="parent_id">
										<option value="0">Chọn chức năng cha</option>
										<option v-for="listCha in listChucNangCha" :key="listCha.id" :value="listCha.id">{{listCha.name}}</option>
									</select>
								</div>
								
							</div>
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-primary btn-sm">Thêm chức năng</button>
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
					<list :listData="listChucNang" @deleted='loadData'></list>
				</div>
				<div class="col-md-12 trang justify-content-end">
					<paginate :last_pages="listChucNang.last_page" @loadData='loadData'></paginate>
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
export default {
	data(){
		return{
			tieude:'THÊM CHỨC NĂNG',
			link:'Thêm',
			name:'',
			display_name:'',
			key_code:'',
			parent_id:0,
			error:'',
			listData:'',
			chuc_nang_cha:'',
			message:'',
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
				if(error.response.data.errors == undefined){
					this.message = "Bạn không có quyền thực hiện thao tác này !";
				}
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