<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="spanel-title">
				{{model.company}} / {{model.name}}
			</span>
			<div>
				<router-link :to="'/customer/'+model.id+'/edit'" class="btn btn-primary btn-sm">Edit</router-link>
				<button class="btn btn-danger btn-sm" @click="remove">Delete</button>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
					<label>Company</label>
					<p>{{model.company}}</p>
					<label>Name</label>
					<p>{{model.name}}</p>
				</div>
				<div class="col-sm-4">
					<label>Email Address</label>
					<p>{{model.email}}</p>
					<label>Phone Number</label>
					<p>{{model.phone}}</p>
				</div>
				<div class="col-sm-4">
					<label>Created At</label>
					<p>{{model.created_at}}</p>
					<label>Address</label>
					<p>{{model.address}}</p>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import Vue from 'vue'
	import axios from 'axios'
	export default {
		name:'CategoryShow',
		data(){
			return {
				model:{},
				resource:'customer',
				redirect:'/'
			}
		},
		beforeMount(){
			this.fetchData()
		},
		watch:{
			'$route':'fetchData'
		},
		methods:{
			remove(){
				var vm = this
				axios.delete(`api/${this.resource}/${this.$route.params.id}`)
					.then(function(res){
						if(res.data.deleted){
							vm.$router.push(vm.redirect)
						}
					}).catch(function(error){
						console.log(error)
					})
			},
			fetchData() {
				var vm = this
				axios.get(`/api/${this.resource}/${this.$route.params.id}`)
					.then((res) => {
						Vue.set(vm.$data,'model',res.data.model)
					})
					.catch((error) =>{
						console.log(error)
					});
			}
		}
	}
</script>