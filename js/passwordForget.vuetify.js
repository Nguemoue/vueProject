var vm =   new Vue({
    el: '#app',
    vuetify: new Vuetify(),

    data:{
        model:{
            form:true,
            form2:true,
            form3:true,
        },
        show:{
            password:true,
        },
        rules:{
            email:[
            v => !!v || "l'adresse mail est requise",
            (v)=>{
                var regPattern = new RegExp("^[a-zA-Z0-9._-]{1,64}@([a-zA-Z0-9-]{2,25}\\.[a-zA-Z.]{2,6})$")
                return regPattern.test(v) || 'Adresse Mail invalide'
            }],
            password:[
                v => !!v || "le mot de passe est requise",
            ]
        },
        breadcrumbs:{
            items:[
            {text:'Acceuil',href:'index.php',disabled:false},
            {text:'Compte',href:'user.php',disabled:false},
            {text:'Mot de Passe Oublié',href:'',disabled:true}
            ]
        }
    }
})