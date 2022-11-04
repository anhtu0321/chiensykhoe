<template>
    <div>
        <form style="position:relative" method="post" enctype="multipart/form-data" @submit.prevent="doimatkhau">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label>Mật khẩu cũ</label>
                    <input type="password" class="form-control form-control-sm" v-model="oldpass" :class="{'is-invalid':(error && error.oldpass)}" @focus="removeErr">
                    <p class="thongbao" v-if="error && error.oldpass">{{ error.oldpass[0]}}</p>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Mật khẩu mới</label>
                    <input type="password" class="form-control form-control-sm" v-model="newpass" :class="{'is-invalid':(error && error.newpass)}" @focus="removeErr">
                    <p class="thongbao" v-if="error && error.newpass">{{ error.newpass[0]}}</p>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Nhập lại mật khẩu mới</label>
                    <input type="password" class="form-control form-control-sm" v-model="renewpass" :class="{'is-invalid':(error && error.renewpass)}" @focus="removeErr">
                    <p class="thongbao" v-if="error && error.renewpass">{{ error.renewpass[0]}}</p>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3 text-right">
                    <button class="btn btn-primary btn-sm"><i class="fas fa-key"></i> Đổi mật khẩu</button>
                </div>
            </div>
            <div class="form-row" v-if="alertChangePass != ''">
                <div class="col-md-12 mb-3 ">
                    <div class="alert alert-success">{{alertChangePass}}</div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return{
            showDropdown:false,
            id:'dropdownUser',
            oldpass:'',
            newpass:'',
            renewpass:'',
            error:'',
            alertChangePass:'',
        }
    },
    methods:{

        doimatkhau(){
            if(this.newpass != this.renewpass){
                this.error = {
                    renewpass:['Nhập lại mật khẩu mới không khớp !']
                }
                return;
            }
            let data = new FormData();
            data.append('oldpass', this.oldpass);
            data.append('newpass', this.newpass);
            data.append('renewpass', this.renewpass);
            axios.post('/chiensykhoe/admin/doimatkhau', data)
            .then(response=>{
                this.alertChangePass = 'Đổi mật khẩu thành công !';
            })
            .catch(error=>{
                this.error = error.response.data.errors;
                this.alertChangePass = '';
            });
        },
        removeErr(){
            this.error ='';
        },
    }
}
</script>

<style scoped>
.thongbao{
    color:red;
}
</style>>

