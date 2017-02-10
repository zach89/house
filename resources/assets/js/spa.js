import Vue from 'vue'
import App from './Spa.vue'
import router from './router'

const app = new Vue({
	el:'#root',
	components: {App},
	template:'<app></app>',
	router
})