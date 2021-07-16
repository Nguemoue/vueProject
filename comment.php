<?php
    #je demaree ma session si elle n'existe pas
    if(!isset($_SESSION)) session_start();
    require 'class/Autoload.php';
    Autoload::register();
    $num = isset($_GET['id'])?$_GET['id']:'0';

?>



<?php require 'includes/template.head.php' ?>
<div id="app">
    <v-app>
        <v-app-bar app color="blue">
            <v-app-bar-title class="font-weight-bold">Commentaire</v-app-bar-title>
        </v-app-bar>
        <v-main app>
            <v-container>
                <h1>Bienvenue Sur Les Commentaire de La Vidéo Numéro : <?= $num ?></h1>
            </v-container>
            <!-- je cree ma card pour les commentaires -->
            <v-card>

            </v-card>
        </v-main>
    </v-app>
</div>


<?php require 'includes/template.bottom.php' ?>
<script defer="" src="js/comment.vuetify.js"></script>