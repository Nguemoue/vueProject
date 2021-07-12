var vm =   new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data:{
        items: [
          {title: 'Teatchings', icon: 'mdi-play-box', href:'teatching.php' },
          {title: 'Encounters ', icon: 'mdi-human-male-female' , href:"encounters.php"},
          {title:  'BLible Stories',  icon: 'mdi-book', href:"bibleStories.php"},
          {title:'Soaking Worship',icon:'mdi-music-note-eighth-dotted',href:'soakingWorship.php'},
          {title:'Prayer Lines ',icon:'mdi-church',href:'prayerLines.php'},
          {title:'Trainings',icon:'mdi-elevation-rise',href:'training.php'},
          {title: 'Library', icon: 'mdi-help-box', href:"library.php" },
          {title: 'Shop', icon: 'mdi-shopping', href:"shop.php" },
          {title: 'About', icon: 'mdi-help-box', href:"about.php" },
      ],
         showpass:true,
    }
})