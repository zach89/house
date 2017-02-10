<template lang="html">
    <div class="chat-composer">
    	<input type="text" placeholder="Start typing" v-model="messageText" @keydown.enter="sendMessgae">
    	<button class="btn btn-primary" @click="sendMessgae">Send</button>
    </div>
</template>
<script>
    export default {
    	data(){
    		return{
    			messageText:''
    		}
    	},
    	methods:{
    		sendMessgae(){
    			this.$emit('messagesent',{
    				message:this.messageText,
    				user:{name:$('.navbar-right .dropdown-toggle').text().trim()}
    			})
    			this.messageText = '';
    		}
    	}
    }
</script>

<style lang="css">
.chat-composer{
	display:flex;
}
.chat-composer input {
	flex: 1 auto;
}
.chat-composer button{
	border-radius: 0;
}

</style>