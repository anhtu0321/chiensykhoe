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
								<button type="submit" class="btn btn-primary btn-sm">Thêm Phân quyền</button>
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
					<list :listData='listData' @deleted="loadData()"></list>
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
	import list from '../group/list'
	import paginate from '../group/page'
export default {
    data(){
        return {
            tieude:'THÊM NHÓM QUYỀN',
            link:'Thêm',
			name:'',
			display_name:'',
			mangcha:[],
			mangcon:[],
			error:'',
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
		add(){
			// console.log(this.mangcon);
			let data = new FormData;
			data.append('name', this.name);
			data.append('display_name', this.display_name);
			for(var i in this.mangcon){
				data.append('mangcon[]', this.mangcon[i]);
			}
				axios.post('/chiensykhoe/admin/addRole', data)
				.then(()=>{
					this.$store.dispatch('acListRole', this.page);
					this.name='';
					this.display_name='';
					this.mangcha='';
					this.mangcon='';
				})
				.catch(e=>{
					this.error = e.response.data.errors;
					if(e.response.data.errors == undefined){
						this.message = "Bạn không có quyền thực hiện thao tác này !";
					}
				});

		},
		loadData(){
			this.$store.dispatch('acListRole', this.page);
		}

	},
    components:{
        contentHeader, list, paginate
    },
	mounted(){
		if(this.$store.state.listChucNangCha == ''){
			this.$store.dispatch('acListChucNangCha');
		}
		this.$store.dispatch('acListRole', this.page);
	}
}
</script>

<style>

</style>