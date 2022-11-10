<template>
    <div class="danh-sach">
        <div class="danh-sach__title">THÊM DANH SÁCH KIỂM TRA</div>
        <div class="danh-sach__content">
            <form method="post" @submit.prevent='add'>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Tên danh sách kiểm tra</label>
                        <input type="text" class="form-control" v-model="ten_danh_sach">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Năm kiểm tra</label>
                        <input type="text" class="form-control" v-model="nam">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Quy tắc xếp loại</label>
                        <select class="form-control" v-model="quy_tac">
                            <option value="0">--- Chọn quy tắc xếp loại ---</option>
                            <option value="1">Theo thông tư 02 ngày 20/2/2022</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-info">Thêm danh sách</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            ten_danh_sach:'',
            nam:'',
            quy_tac:0
        }
    },
    methods:{
        add(){
            let data = new FormData();
            data.append('ten_danh_sach', this.ten_danh_sach);
            data.append('nam', this.nam);
            data.append('quy_tac', this.quy_tac);
            axios.post('/chiensykhoe/addDanhSach', data)
            .then(response=>{
                this.ten_danh_sach="";
                this.nam="";
                this.quy_tac=0;
            })
            .catch(err=>{
                
            })
        }

    }
}
</script>

<style lang="scss" scoped>
    .danh-sach{
        font-family: 'Montserrat';
        position:relative;
    }
    .danh-sach__content{
        border:1px solid #bbbbbb;
        padding:10px;
        border-radius:5px;
        margin-top:30px;
    }
    .danh-sach__title{
        position:absolute;
        height:20px;
        line-height: 20px;
        font-size: 1.1em;
        font-weight: bold;
        background:#ffffff;
        left:30px;
        top:-10px;
        padding:0px 10px;
    }
</style>>

