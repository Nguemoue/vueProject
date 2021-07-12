/**
|--------------------------------------------------
| on gere la partie reactive en javascript
|--------------------------------------------------
*/
/**
 * par convention on nomme nos donnes en anglais notation kamelCase
 * */
var vm = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: {
        validForm:true,
        rules:{
            file:[
            (v)=>{
                var max = window.Math.pow(10, 6)*2
                if(v.size>max){
                    return 'La taille doit etre moins de 2 MB'
                }
                return true
            },

            v=>!!v || 'Ce champ est requis'
            ],
            email:[
            (v)=>{
                var regPattern = new RegExp("^[a-zA-Z0-9._-]{1,64}@([a-zA-Z0-9-]{2,25}\\.[a-zA-Z.]{2,6})$")
                return regPattern.test(v) || 'Adresse Mail invalide'
            },
            v => !!v || 'Ce champ est requis'
            ],
            nom:[
            v => !!v || 'Ce champ est requis'
            ],

        },
        passwordRules:[
                v=>!!v || 'Le mot de passe est requis',
            ],
            confirmPasswordRules:[
                v => !!v || 'Le mot de passe est requis',
                v => {
                    if(this.passwordModel == this.confirmPasswordModel)
                        return true
                     return  'les mots de passe doivent être identique'
            }],
        model:{
            nom:null,
            age:null,
            sexe:null,
            email:null,
            tel:null,
            password:null,
            confirmPassword:null,
        },
        passwordModel:null,
        confirmPasswordModel:null,
        items: [{
            text: 'Acceuil',
            href: 'lucas',
            disabled: false
        }, {
            text: 'Comptes',
            href: 'moi',
            disabled: false
        }, {
            text: 'Creation',
            href: 'luca',
            disabled: true
        }],
        stepper:1,
        villes: [
            "Bafoussam", "Douala", "Yaounde", "Badjoun", "Dscang", "Maroua", "Garoua", "Ngaoundere", "Nkongsamba", "Buea", "Limbe", "Edea",
        ],
        codes: {
            Cameroun: 237,
            Gabon: 240,
            France: 33,
            Angleterre: 1,
            Nigeria: 1,
            Congo: 227
        },
        pays: ['Cameroun', 'Gabon', 'France', 'Angleterre', 'Nigeria', 'Congo'],
        pay: 'Cameroun',
        dialog: false,
        dialog1: true,
        ville: "baf",
        passwordVisible: false,
        confirmPasswordVisible: false,
        loading: false,
        resetLoading: false,
        loader: null,
        values:{
            age:14
        },
        resetLoader: false,
        countries: null,
        res: [],
        rulesName: [],
        rulesEmail: [],
        rulesAge: [],
        ruleTel: [],
    },
    beforeMounted() {
        var xhr = new XMLHttpRequest();
        var result, final = [];
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                result = xhr.responseText;
            }
        }
        xhr.open('GET', 'http://localhost/phpTest/api/json/countries.php', true)
        xhr.send()
        result = JSON.parse(result)
        result = JSON.parse(result)
        var keys = new Object.keys(result);
        keys.forEach((elt) => {
            final.push(result[elt])
        })},
    watch: {
        loader() {
            this.loading = true;
            window.setTimeout(() => {
                this.loading = false
            }, 3000)
        },
        resetLoader() {
            this.resetLoading = true;
            window.setTimeout(() => {
                this.resetLoading = false;
            }, 500)
            this.resetLoader = false
        }
    }
})