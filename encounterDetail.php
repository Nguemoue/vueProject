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
  $all_videos = $table_encounter->find();
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
    <v-app-bar app color="blue" short>
      <v-app-bar-nav-icon outlined>
        <template #default>
          <v-icon>mdi-arrow-left</v-icon>
        </template>
      </v-app-bar-nav-icon>
      <v-app-bar-title>Regarder</v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn icon @click="model.navigation=!model.navigation">
        <v-icon>mdi-menu</v-icon>
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer app v-model="model.navigation" class="red lighten-2">
      <v-toolbar color="red">
        <v-toolbar-tile class="font-weight-bold">MENU</v-toolbar-tile>
        <v-spacer></v-spacer>
        <v-btn icon x-large outlined @click="model.navigation=!model.navigation">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
    </v-navigation-drawer>
    <v-main app>
      <v-container>
        <h1 class="text-h6 text-center"> Nombres D'encounters Disponible : (<?=$nb_encounter?>)</h1>
        <v-row>
          <v-col cols="12" md="8" lg="7" xl="6">
            <v-card>
              <v-toolbar color="blue">
                <v-toolbar-title class="white--text"><?=$titre?></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-menu transition="scale-transition" bottom offset-y>
                  <template #activator="{on,attr}">
                    <v-btn icon v-bind="attr" v-on="on">
                      <v-icon>mdi-information</v-icon>
                    </v-btn>
                  </template>
                  <v-card flat min-height="200px" class="py-5 px-5">
                    description de l'encounter:
                    <hr>
                    <v-container>
                        <?=$desc?>
                    </v-container>
                  </v-card>
                </v-menu>
              </v-toolbar>
              <v-card flat>
                <video src="<?=$path?>" controls width="100%" poster="<?=$poster?>"></video>
              </v-card>
              <v-card-actions>
                <v-btn icon><v-icon>mdi-thumb-up</v-icon></v-btn>
                <v-btn icon><v-icon>mdi-thumb-down</v-icon></v-btn>
                <v-spacer></v-spacer>
                <v-divider vertical></v-divider>
                <v-btn icon>
                  <v-icon>mdi-comment</v-icon>
                </v-btn>
                <v-divider vertical></v-divider>
                <v-btn icon>
                  <v-icon>mdi-download</v-icon>
                </v-btn>
                <v-divider vertical></v-divider>
                <v-btn icon>
                  <v-icon>mdi-share</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
        <h1 class='text-center text-decoration-underline mb-5'>Autres</h1>
        <v-row>
          <!-- mon container pour les auutres  -->
            <v-container>
               <v-row>
                  <v-card elevation="3" class="mb-5" >
                     <v-tabs v-model="model.tab" grow background-color="grey" icons-and-text >
                        <v-tabs-slider></v-tabs-slider>
                        <v-tab href="#tab-1"> Description
                           <v-icon>mdi-eyedropper</v-icon>
                        </v-tab>
                        <v-tab href="#tab-2"> Decouvrir <v-icon>mdi-led-on</v-icon>
                        </v-tab>
                     </v-tabs>
                     <v-tabs-items v-model="model.tab">
                        <v-tab-item value="tab-1" style="width:100%">
                           <v-card elevation="4" width="100vw" min-height="200px" class="py-5">
                              <h3 class="text-center">
                               <?= empty($desc)?'Aucune description':$desc ?>
                              </h3>
                           </v-card>
                        </v-tab-item>
                        <v-tab-item value="tab-2" key="2" >
                           <v-card elevation="4" width="100vw" min-height="200px" class="py-5">
                             <v-list nav>
                                <v-list-item-group  color="blue">
                                   <?php foreach ($all_videos as $key => $value): ?>
                                   <?php
                                     $img_path=$table_encounter->getPoster($table_image,$value['id_img']);
                                      $img_path=$app->getImage("dailybreads",$img_path);
                                   ?>
                                   <v-list-item link
                                      <?= $_GET['id'] == $value["id"] ?'disabled':'' ?>
                                      href="<?=$_SERVER['PHP_SELF'].'?id='.$value['id'];?>"
                                      color="blue" key="<?=$key?>">
                                         <v-list-item-avatar>
                                            <v-img src="<?=$img_path?>"></v-img>
                                         </v-list-item-avatar>
                                         <v-list-item-content>
                                           <v-list-item-title>
                                              <b> <?=$value['titre']?> </b>
                                           </v-list-item-title>
                                           <v-list-item-subtitle>Video en cours de lecture.....
                                           </v-list-item-subtitle>
                                         </v-list-item-content>
                                         <?php if ($_GET['id'] == $value['id']): ?>
                                         <v-list-item-actions>
                                          <v-icon>mdi-eye</v-icon>
                                         </v-list-item-actions>
                                         <?php endif ?>
                                   </v-list-item>
                                   <?php endforeach ?>
                                </v-list-item-group>
                             </v-list>
                           </v-card>
                        </v-tab-item>
                     </v-tabs-items>
                  </v-card>
               </v-row>
            </v-container>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</div>


<?php require 'includes/template.bottom.php' ?>
<script src="js/encounterDetail.vuetify.js" defer=""></script>