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

						</form>
						<!-- end form -->
					</div>
				</div>
			</div>
  		</section>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10 list">
					<list :listData='listData' @deleted="loadData()"></list>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-md-10 trang justify-content-end">
                <paginate :last_pages="listData.last_page" @loadData="loadData"></paginate>
            </div>
        </div>
	</div>
</template>

<script>
export default {
    data(){
        return{
            tieude:'SỬA NHÓM QUYỀN',
            link:'Sửa',
        }
    }
}
</script>

<style>

</style>