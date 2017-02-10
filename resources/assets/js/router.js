import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
// import Customer from './views/customer/index.vue'
// import CustomerEdit from './views/customer/edit.vue'
// import CustomerShow from './views/customer/show.vue'
// import Invoice from './views/invoice/index.vue'
const router = new VueRouter({
	// mode: 'history',
	routes: [
		{path:'/',component:require('./views/customer/index.vue')},
		{path: '/customer/create', component: require('./views/customer/form.vue')},
		{path:'/Customer/:id/edit',component: require('./views/customer/form.vue'), meta: {mode: 'edit'}},
		{path:'/Customer/:id',component:require('./views/customer/show.vue')},

		{path: '/invoice', component: require('./views/invoice/index.vue')},
       	{path: '/invoice/create', component: require('./views/invoice/form.vue')},
       	{path: '/invoice/:id/edit', component: require('./views/invoice/form.vue'), meta: {mode: 'edit'}},
       	{path: '/invoice/:id', component: require('./views/invoice/show.vue')},
	]
});

export default router