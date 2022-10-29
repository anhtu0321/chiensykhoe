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
								<div class="form-group col-md-6">
									<label class="col-form-label col-form-label-sm">Tên quyền</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.name)}" 
										v-model="name">
									<p class="thongbao" v-if="error && error.name">{{ error.name[0]}}</p>
								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label col-form-label-sm">Tên Đầy đủ</label>
									<input type="text" class="form-control form-control-sm" 
										:class="{'is-invalid' : (error && error.display_name)}" 
										v-model="display_name">
									<p class="thongbao" v-if="error && error.display_name">{{ error.display_name[0]}}</p>
								</div>
								
							</div>
							<div class="row"> 
								<!-- row for permission -->
								<div class="col-md-12 mb-4">
									<input type="checkbox" class="hovered check-all" id="checkall" v-model="check_all" @change="checkAll">
									<label for="checkall" class="p-2 title-card hovered" >Chọn tất cả chức năng</label>
								</div>
								<div class="col-md-6" v-for="permission in listChucNangCha" :key="permission.id">
									<div class="card border-info mb-4">
										<div class="card-header">
											<input type="checkbox" class="hovered check-cha" :value="permission.id" :id="permission.id" @change="checkModule()" v-model="mangcha">
											<label :for="permission.id" class="p-2 title-card hovered">{{permission.name}}</label>
										</div>
										<div class="card-body text-info">
											<div class="row">
												<div class="col-md-6" v-for="percon in permission.per_child" :key="percon.id">
													<input type="checkbox" :value="percon.id" :id="percon.id" class="hovered check-con" @change="checkChild()" v-model="mangcon">
													<label :for="percon.id" class="card-text p-2 hovered">{{ percon.name }}</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- end row permission -->
							<div class="form-group col-md-12 text-right">
								<button type="submit" class="btn btn-success btn-sm" >Sửa Chức năng</button>
								<router-link to="/role" class="btn btn-warning btn-sm">Quay lại</router-link>
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
					<list :listData='listData' @deleted="loadData" @loadDataById="getDataById"></list>
				</div>
				<div class="col-md-12 trang justify-content-end">
					<paginate :last_pages="listData.last_page" @loadData="loadData"></paginate>
				</div>
			</div>
		</div>
		
	</div>
</template>

<script>
	import contentHeader from '../content_header' 
	import list from '../group/list.vue'
	import paginate from '../group/page'
export default {
    data(){
        return{
            tieude:'SỬA NHÓM QUYỀN',
            link:'Sửa',
			error:'',
			name:'',
			display_name:'',
			mangcha:[],
			mangcon:[],
			check_all:false,
			message:'',
        }
    },
	computed:{
		listChucNangCha(){
			return this.$store.state.listChucNangCha;
		},
		listChucNangCon(){
			var arr = [];
			for( var i in this.listChucNangCha){
				for(var j in this.listChucNangCha[i].per_child){
					arr.push(this.listChucNangCha[i].per_child[j].id);
				}
			}
			return arr;
		},
		listData(){
			return this.$store.state.listRole;
		},
		page(){
			return this.$store.state.pageRole;
		}
	},
	methods:{
		checkAll(){
			this.mangcha=[];
			this.mangcon=[];
			if(this.check_all){
				for (var i in this.listChucNangCha) {
					this.mangcha.push(this.listChucNangCha[i].id);
				}
				for (var i in this.listChucNangCon) {
					this.mangcon.push(this.listChucNangCon[i]);
				}
			}
		},
		checkModule(){
			var checkCha = event.target;
			var checkCon = checkCha.parentNode.parentNode.getElementsByClassName('check-con');
			for (var i = 0; i < checkCon.length; i++) {
				if(checkCha.checked == true && this.mangcon.indexOf(parseInt(checkCon[i].value)) == -1){
					this.mangcon.push(parseInt(checkCon[i].value));
				}
				if(checkCha.checked == false && this.mangcon.indexOf(parseInt(checkCon[i].value)) != -1){
					this.mangcon.splice(this.mangcon.indexOf(parseInt(checkCon[i].value)),1);
					this.check_all = false;
				}
			}
			if (this.listChucNangCon.length == this.mangcon.length){
				this.check_all = true;
			}
		},
		checkChild(){
			var target = event.target;
			var checkCon = target.parentNode.parentNode.getElementsByClassName('check-con');
			var checkCha = target.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('check-cha');
			if(target.checked == false && this.mangcha.indexOf(parseInt(checkCha[0].value)) != -1){
				this.mangcha.splice(this.mangcha.indexOf(parseInt(checkCha[0].value)),1);
			}
			if(target.checked == true){ //dang xu ly
				let check = true;
				for( var i = 0; i < checkCon.length; i++){
					if(checkCon[i].checked == false){
						check = false;
					}
				}
				if(check == true && this.mangcha.indexOf(parseInt(checkCha[0].value)) == -1){
					this.mangcha.push(parseInt(checkCha[0].value));
				}
			}
			if (this.listChucNangCon.length == this.mangcon.length){
				this.check_all = true;
			}else{
				this.check_all = false;
			}
		},
		getDataById(id){
			var n = 0;
			var load = ()=>{
				axios.get('/chiensykhoe/admin/getRole/'+id)
				.then(response=>{
					this.name = response.data[0].name;
					this.display_name = response.data[0].display_name;
					// xu ly nut check con
					this.mangcon = response.data[0].permission.map(e=>{
						return e.id;
					});
					// xu ly nut check all
					if(this.mangcon.length == this.listChucNangCon.length){
						this.check_all = true;
					}else{
						this.check_all = false;
					}
					// xu ly nut check module
					var arr_cha = this.listChucNangCha.map(e=>{return e.id});
					for(var i in this.listChucNangCha){
						for(var j in this.listChucNangCha[i].per_child){
							if(this.mangcon.includes(this.listChucNangCha[i].per_child[j].id) == false){
								arr_cha = arr_cha.filter(e=>{return e !== this.listChucNangCha[i].id});
								// arr_cha.splice(arr_cha.indexOf(parseInt(this.listChucNangCha[i].id)),1); //day la cach 2
								break;
							};
						}
					}
					this.mangcha = arr_cha;
				})
				.catch(e=>{
					n+=1;
					if(n<5){
						load();
					}
					
				})
			}
			load();
		},
		loadData(){
			this.$store.dispatch('acListRole', this.page);	
		},
		edit(){
			var data = new FormData;
			data.append('name', this.name);
			data.append('display_name', this.display_name);
			for(var i in this.mangcon){
				data.append('mangcon[]', this.mangcon[i]);
			}
			axios.post('/chiensykhoe/admin/updateRole/'+this.$route.params.id, data)
			.then( response =>{
				this.$store.dispatch('acListRole',this.page);
				swal('Cập nhật thành công !');
			})
			.catch( e=>{
				this.error = e.response.data.errors;
				if(e.response.data.errors == undefined){
					this.message = "Bạn không có quyền thực hiện thao tác này !";
				}
			})
		}
	},
	components:{
		list, contentHeader, paginate
	},
	mounted(){
		if(this.$store.state.listChucNangCha == ''){
			this.$store.dispatch('acListChucNangCha');
		}
		this.getDataById(this.$route.params.id);
		if(this.$store.state.listRole == ''){
			this.$store.dispatch('acListRole',this.page);
		}
	}
}
</script>

<style>

</style>