var vm =   new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data:{
        breadcrumbs:[
            {text:'Acceuil',href:'index.php',disabled:false},
            {text:'Account',href:'',disabled:true}
         ],
         showpass:true,
         stepper:null,
         dialog:false,
         Sdialog:false,
         DDialog:false,
         model:{
            profil:true,
            modification:true
         },
         rules:{
            tel:[
                v=>!!v || "le numéro de téléphone est requis"
            ],
            nom:[
            v=>!!v || "le Nom est requis"
            ],
            pays:[
            v=>!!v || "le Pays est requis"],
            ville:[
            v=>!!v || "la ville est requise"],
            password:[
            v=>!!v || "le Not de passe est requis ",
            v=>v.length<20 || "le mot de passe doît être moins de 2à caractères"
            ],
            file:[
                v=>!!v || "l'image est requis",
                v=>v.size<(1024*1024*2) || "la taille du fichier doit être moins de 2 méga"
            ]
         }
    }
})