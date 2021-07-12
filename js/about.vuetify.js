var vm =   new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data:{
        items:[
            {text:'Acceuil',href:'lucas',disabled:false},
            {text:'Connexion',href:'luca',disabled:true}
         ],
         showpass:true,
    },
    watch:{

    }
})