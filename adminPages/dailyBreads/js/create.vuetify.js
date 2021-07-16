var vm = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: {
        model: {
            form: true,
            titre: null,
            nom: null,
            description: null
        },
        rules: {
            img: [
                v => !!v || "l'image est requise",
                v => v.size <= (Math.pow(10, 6) * 2) || "la taille de l'image ne depasse pas 2 MB"
            ],
            titre: [
                v => !!v || "le titre est requis"

            ],
            nom: [
                v => !!v || "le nom du daily est requis"
            ], description: [
                v => !!v || "la description est requise"
            ]
        }
    }
})