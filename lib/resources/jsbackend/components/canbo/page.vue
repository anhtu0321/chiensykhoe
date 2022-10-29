<template>
	<nav aria-label="Page navigation example">
		<ul class="pagination justify-content-end">
			<li class="page-item" @click.prevent="prev()"><a class="page-link" href="#">Previous</a></li>
			<li class="page-item" :class="{'active': currentPage==page}" @click.prevent="setPage(page)" v-for="page in pagesNumber" :key="page"><a class="page-link" href="#">{{ page }}</a></li>
			<li class="page-item" @click.prevent="next()"><a class="page-link" href="#">Next</a></li>
		</ul>
	</nav>
</template>

<script>
export default {
    data(){
    	return{
			currentPage: 1,
			offset: 4,
			from:1,
			to:1,
		}
    },
    props:['last_pages'],
	computed: {
            pagesNumber() {
				if(this.last_pages == null){return [];}
				if(this.last_pages<=this.offset*2+1){
					this.from = 1;
					this.to = this.last_pages;
				}else{
					if(this.currentPage <= this.offset){
						this.from = 1;
						this.to = 1 + this.offset*2;
						if(this.to > this.last_pages){
							this.to = this.last_pages;
						}
					}
					if((this.currentPage> this.offset) && (this.currentPage <= this.last_pages - this.offset)){
						this.from = this.currentPage - this.offset;
						this.to = this.currentPage + this.offset;
					}
					if(this.currentPage >this.last_pages - this.offset){
						this.from = this.last_pages - this.offset*2;
						this.to = this.last_pages;
					}
				}
                var pagesArray = [];
                for (var i=this.from; i <= this.to; i++) {
                    pagesArray.push(i);
                }
                return pagesArray;
            },
			
        },
	methods:{
		setPage(newPage){
			this.currentPage = newPage;
			this.$store.dispatch('acPageDonvi', newPage);
			this.$emit('loadData');
		},
		prev(){
			if(this.currentPage > 1){
				this.currentPage--;
				this.$store.dispatch('acPageDonvi', this.currentPage);
				this.$emit('loadData');
			}
		},
		next(){
			if(this.currentPage < this.last_pages){
				this.currentPage++;
				this.$store.dispatch('acPageDonvi', this.currentPage);
				this.$emit('loadData');
			}
		}
	},
	created(){
		this.currentPage = this.$store.state.pageDonvi;
	}

}
</script>

<style>

</style>