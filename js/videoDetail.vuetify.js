var vm =   new Vue({
    el: '#app',
    vuetify: new Vuetify(),

    data:{
        nvd:false,
        snackbarl:false,
        snackbaru:false,
        nvds:false,
        like:false,
        unlike:false,
        breadcrumbs:[
            {text:'Acceuil',href:'lucas',disabled:false},
            {text:'Videos',href:'luca',disabled:true}
         ],
                items: [
          {title: 'Teatchings', icon: 'mdi-play-box', href:'video.php' },
          {title: 'Encounters ', icon: 'mdi-human-male-female' , href:"rencontre.php"},
          {title:  'BLible Stories',  icon: 'mdi-book', href:"biblestories.php"},
          {title:'Soaking Worship',icon:'mdi-music-note-eighth-dotted',href:'soaking.php'},
          {title:'Prayer Lines ',icon:'mdi-church',href:'prayer.php'},
          {title:'Trainings',icon:'mdi-elevation-rise',href:'training.php'},
          {title: 'Library', icon: 'mdi-help-box', href:"library.php" },
          {title: 'Shop', icon: 'mdi-shopping', href:"shop.php" },
          {title: 'About', icon: 'mdi-help-box', href:"about.php" },
      ],
      texts:[
      {text:'voici la description de la video',id:2},
      {id:2,text:'voivi les autre videos'}
      ],
      tab:null,
      lg:1,
    showpass:true,
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',

    }
})