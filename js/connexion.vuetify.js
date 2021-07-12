var vm =   new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data:{
        items:[
            {text:'Acceuil',href:'index.php',disabled:false},
            {text:'Comptes',href:'user.php',disabled:false},
            {text:'Connexion',href:'',disabled:true}
         ],
         showpass:true,
         model:{
            form:true,
            email:null,
            password:null
        },
        rules:{
            email:[
            (v)=>{
                var regPattern = new RegExp("^[a-zA-Z0-9._-]{1,64}@([a-zA-Z0-9-]{2,25}\\.[a-zA-Z.]{2,6})$")
                return regPattern.test(v) || 'Adresse Mail invalide'
            },
            v=> !!v || "L'adresse mail ne doit pas être vide"
            ],
            password:[
                v=> !!v || "Mot de passe ne doit pas être vide"
            ],
        }
    }
})