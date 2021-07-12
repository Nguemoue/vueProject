var vm = new Vue({
    el:'#app',
    vuetify:new Vuetify(),
    data:{
        message:null,
        dialog:false,
    },
    methods:{
        send(){
            this.$refs.message_box.submit();
        }
    }
})