var vm = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data:{
        picker: new Date().toISOString().substr(0, 10),
        time: new Date().getMinutes()+':'+(new Date().getMinutes()),
        menu_model:null,
        showSideBar:false,
        items:[
            {title: 'Teatchings', icon: 'mdi-play-box', href:'teatching.php' },
            {title: 'Encounters ', icon: 'mdi-human-male-female' , href:"encounters.php"},
            {title: 'BLible Stories',  icon: 'mdi-book-open-variant', href:"bibleStories.php"},
            {title:'Soaking Worship',icon:'mdi-music-note-eighth-dotted',href:'soakingWorhsip.php'},
            {title:'Prayer Lines ',icon:'mdi-church',href:'prayeLines.php'},
            {title:'Trainings',icon:'mdi-elevation-rise',href:'trainings.php'},
            {title: 'Library', icon: 'mdi-help-box', href:"library.php" },
            {title: 'Shop', icon: 'mdi-shopping', href:"shop.php" },
            {title: 'About', icon: 'mdi-help-box', href:"about.php" },
        ],
        values:{
            age:14,
        },
        states:[
            { name: 'Florida', abbr: 'FL', id: 1 },
            { name: 'Georgia', abbr: 'GA', id: 2 },
            { name: 'Nebraska', abbr: 'NE', id: 3 },
            { name: 'California', abbr: 'CA', id: 4 },
            { name: 'New York', abbr: 'NY', id: 5 },
        ],
        sbmodel:0,
        searchModel:true,
        carousel:1,
        searchText:'rechercher'
        },
        methods:{
            appl(){
            console.log(this.$refs);
        },
        prevCarousel(){
            this.$refs.carousel.prev()
        },
        nextCarousel(){
            this.$refs.carousel.next()
        }
    },
})

//

  var elt  = document.getElementById('appName')
  var data  = new Typewriter(elt,{}).typeString("Bienvenue").pauseFor(100).typeString(" Sur ").typeString("<span class='blue--text font-weight-bold'>L.I.G.H.T</span>").start()
