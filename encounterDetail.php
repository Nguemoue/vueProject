<?php
  #code du traitemet
  require 'class/Autoload.php';
  Autoload::register();
  $table = Table::getInstance();
  $app   = App::getInstance();

  $table_image     = $table->get('image');
  $table_encounter = $table->get('encounter');

  $all_encounter = $table_encounter->find();

  $nb_encounter = count($all_encounter);
  #je recupere l'id de la video
  if(isset($_GET['id']))
    $id = $_GET['id'];
  else
    die("Erreur Lors Du Chargement Du Contenu <a href='index.php'>retour</a>");
  #je recupere les information suivant l'id de la video
  $info = $table_encounter->findById($id);
  $id_img = $info['id_img'];
  $path = $info['path'].".".$info['extension'];
  $path = $app->getImage("all_cat",$path);
  $titre = $info['titre'];
  $file_name = $table_encounter->getPoster($table_image,$id_img);
  $poster = $app->getImage('dailybreads',$file_name);
  $desc   = $info['description'];



?>

<?php require 'includes/template.head.php' ?>

<div id="app">
  <v-app>
    <v-app-bar app>
      Regarder
    </v-app-bar>
    <!-- <v-navigation-drawer app></v-navigation-drawer> -->
    <v-main app>
      <v-container>
        <h1 class="text-h6 text-center"> Nombres D'encounters Disponible : (<?=$nb_encounter?>)</h1>
        <v-row>
          <v-col cols="12" md="8" lg="7" xl="6">
            <v-card>
              <v-toolbar color="#4EC">
                <v-toolbar-title><?=$titre?></v-toolbar-title>
              </v-toolbar>
              <v-card flat>
                <video src="<?=$path?>" controls width="100%" poster="<?=$poster?>"></video>
              </v-card>
              <v-card-actions>
                <v-btn icon><v-icon>mdi-thumb-up</v-icon></v-btn>
                <v-btn icon><v-icon>mdi-thumb-down</v-icon></v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
        <h1 class='text-center'>Autres</h1>
        <v-row></v-row>
      </v-container>
    </v-main>
  </v-app>
</div>


<?php require 'includes/template.bottom.php' ?>
<script src="js/encounterDetail.vuetify.js" defer=""></script>