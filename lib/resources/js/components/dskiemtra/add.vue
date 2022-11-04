<template>
    <div class="danh-sach">
        <div class="danh-sach__title">THÊM DANH SÁCH KIỂM TRA</div>
        <div class="danh-sach__content">
            <form>
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Tên danh sách kiểm tra</label>
                        <input type="email" class="form-control" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Năm kiểm tra</label>
                        <input type="email" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-info">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {

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

