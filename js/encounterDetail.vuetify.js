var vm = new Vue({
    el:'#app',
    vuetify:new Vuetify(),
    data:{
        model:{
            tab:null,
            navigation:false,
            like:false,
            dislike:false
        }
    },
    methods:{
        like(){
            if(!this.model.like){
                this.model.like = true
            }
        },
        dislike(){
            if(!this.model.dislike){
                this.model.dislike = true
            }
        }
    }
})