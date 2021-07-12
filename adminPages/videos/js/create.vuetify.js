var vm = new Vue({
    el:'#app',
    vuetify:new Vuetify(),
    data:{
        model:{
            categorie:'Teatching'
        },
        items:{
            categorie:['Teatching','Encounter','Prayer Line']
        }
    },
    computed:{
        type(){
            if(this.model.categorie == 'Teatching'){
                return 'du Teatching'
            }else if(this.model.categorie =='Prayer Line')
            return "du Prayer Line"
            return "de L'encounter"
        }
    }
})