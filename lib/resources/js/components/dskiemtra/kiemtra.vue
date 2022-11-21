<template>
    <div class="kiemtra">
        <div class="title">DANH SÁCH: {{this.ten_danh_sach}}</div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data(){
        return{
            ten_danh_sach:'',
        }
    },
    methods:{
        tenDanhSach(){
            var n = 0;
            var load = ()=>{
                axios.get('/chiensykhoe/editDanhsach/'+this.$route.params.id)
                .then(response=>{
                    this.ten_danh_sach = response.data.ten_danh_sach;
                })
                .catch(eror=>{
                    n+=1;
                    if(n<3){load();}
                });
            }
            load();
        },
    },
    mounted(){
        this.tenDanhSach();
    }
}
</script>

<style>

</style>