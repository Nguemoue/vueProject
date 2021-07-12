<?php
    #je demare ma session
if(!isset($_SESSION)) session_start();
    require 'class/Autoload.php';
    Autoload::register();
    $table = Table::getInstance();
    $table_teatching = $table->get('teatching');
    $table_image = $table->get('image');
    $table_videos = $table->get('videos');
    $table_profil = $table->get('profil');
    $table_user = $table->get('users');
    $app = App::getInstance();
    $id_video = (int) $_GET['id'];
    $img = $_GET['img_path'];
    $parts=explode(".", $img);
    $p=pathinfo($img);
    $img_path = $p['filename'];
    $ext_img = $p['extension'];
    $video_path = $table_teatching->getVideo($id_video);
    $poster_path = $app->getImage("dailybreads",$img_path,$ext_img);

    $description = $table_teatching->getDescriptionById($id_video);

    #ke recupere toutes les autres videos avec leurs images respectives
    $all_videos = $table_teatching->find();

 ?>
 <?php require 'includes/template.head.php' ?>


<div id="app">
   <v-app>
      <v-app-bar app  color="blue" elevation="12"  short>
            <v-btn icon href="<?=Helper::previousPage()?>">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-app-bar-title>Regarder</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon href="index.php">
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-divider vertical></v-divider>
            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
            <v-divider vertical></v-divider>
            <v-menu   transition="scale-transition" offset-y left bottom>
                <template #activator="{attrs,on}">
                    <v-btn v-bind="attrs" v-on="on" icon>
                         <v-icon >
                        mdi-dots-vertical
                    </v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item link href="user.php">
                        <v-list-item-action><v-icon>mdi-cogs</v-icon></v-list-item-action>
                        <v-list-item-content><v-list-item-title>configuration</v-list-item-title><v-list-item-subtitle>confirgurez votre profil</v-list-item-subtitle></v-list-item-content>
                    </v-list-item>

                    <v-list-item link>
                        <v-list-item-action><v-icon>mdi-account</v-icon></v-list-item-action>
                        <v-list-item-content>connexion</v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-divider vertical></v-divider>
            <v-app-bar-nav-icon @click="nvd=!nvd">
                <v-icon v-if="nvd">
                    mdi-menu-open
                </v-icon>
            </v-app-bar-nav-icon>
      </v-app-bar>
      <v-navigation-drawer  right app  v-model="nvd"  color="blue lighten-4">
            <template #append>
                <?php if ($app->isConnected()): ?>
                    <v-btn text color="green" class="text-button text-center" block>
                    connecté
                    <v-icon right>
                        mdi-check
                    </v-icon>
                </v-btn>
                <v-btn block color="red" tile small href="logout.php">
                    se deconnecter <v-icon right>mdi-account-off</v-icon>
                    <v-icon></v-icon>
                </v-btn>
            <?php else:?>
                <v-btn text color="red" class="text-button text-center" block>
                    non connecté
                    <v-icon right>
                        mdi-close
                    </v-icon>
                </v-btn>
                <v-btn block color="green" tile small href="logout.php">
                    se connecter <v-icon right>mdi-account-arrow-left</v-icon>
                    <v-icon></v-icon>
                </v-btn>
                <?php endif ?>
            </template>
                <v-divider></v-divider>

                <v-list>
                <v-subheader>profil</v-subheader>
                    <v-list-item>
                        <v-list-item-avatar >
                            <v-img src="<?=$table_user->getProfil($table_profil)?>"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title><?= $table_user->getNom() ?></v-list-item-title>
                        <v-list-item-subtitle><?= $table_user->getEmail() ?></v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
                <v-divider></v-divider>
                <v-list  flat dense>
                    <v-subheader>onglets</v-subheader>
                    <v-list-item-group :value="1" color="green" flat>
                        <v-list-item v-for="item in items">
                    <v-list-item-icon><v-icon>{{ item.icon }}</v-icon></v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                    </v-list-item-group>
                </v-list>
      </v-navigation-drawer>
      <v-main app>
         <v-breadcrumbs :items="breadcrumbs">
                <template #divider>
                    <v-icon>mdi-forward</v-icon>
                </template>
                <template #item={item}>
                    <v-breadcrumbs-item :disabled="item.disabled" :href="item.href">{{  item.text }}</v-breadcrumbs-item>
                </template>
         </v-breadcrumbs>
         <v-container>
            <h1 class="text-center">Liste des Videos (<?=count($all_videos)?>)</h1>
            <h2 class="text-center text-capitalize">
                    <v-badge color="green" content="<?=count($all_videos)?>" overlap>
                        <v-icon x-large>mdi-movie</v-icon>
                    </v-badge>
            </h2>
            <!-- mon container qui affiche la video courante -->
            <v-container>
               <v-row>
                     <v-col cols="12" md="6">
                        <v-card color="grey">
                           <v-toolbar color="grey">
                              <v-toolbar-title>Titre de la video</v-toolbar-title>
                              <v-spacer></v-spacer>
                              <v-btn icon large>
                              <v-icon>mdi-information-outline</v-icon>
                              </v-btn>
                              <v-btn icon>
                                 <v-icon>mdi-dots-vertical</v-icon>
                              </v-btn>
                           </v-toolbar>
                           <video id="v" nohref="nohref" link autobuffer="" height="400px" width="100%" poster="<?=$poster_path?>"
                                   src="<?= $video_path?>" controls=""
                                           style="background-image: cover;">
                           </video>
                           <v-card-actions color="grey">
                              <v-btn icon @click='snackbarl=true;like=true;unlike=false'
                                 :color="like?'blue':'' " class="text--lighten-2">
                                 <v-icon>mdi-thumb-up</v-icon>
                              </v-btn>
                              <v-btn icon @click="snackbaru = true;unlike=true;like=false"
                                    :color="unlike?'blue' : '' " class="text--lighten-2">
                                 <v-icon>mdi-thumb-down</v-icon>
                              </v-btn>
                              <v-snackbar v-model="snackbarl" timeout="1000">
                                 vous venez likez cette video
                                 <template #action>
                                    <v-btn @click="snackbarl = false" text color="red">close</v-btn>
                                 </template>
                              </v-snackbar>
                              <v-snackbar v-model="snackbaru" timeout="1000">
                                 vous venez de unlikez la video
                                 <template #action>
                                    <v-btn @click="snackbaru = false" text color="red">close</v-btn>
                                 </template>
                              </v-snackbar>
                              <v-spacer></v-spacer>
                              <v-btn icon >
                                 <a href="<?= $video_path?>" download=""><v-icon>mdi-download
                                    </v-icon>
                                 </a>
                              </v-btn>
                              <v-btn icon>
                                 <v-icon>mdi-share</v-icon>
                              </v-btn>
                           </v-card-actions>
                        </v-card>
                     </v-col>
               </v-row>
            </v-container>

            <hr>
            <h2 class="text-center">Autre Spécifications </h2><br>
            <!-- mon container pour les auutres  -->
            <v-container>
               <v-row>
                  <v-card elevation="3"  >
                     <v-tabs v-model="tab" grow background-color="grey" icons-and-text >
                        <v-tabs-slider></v-tabs-slider>
                        <v-tab href="#tab-1"> Description
                           <v-icon>mdi-eyedropper</v-icon>
                        </v-tab>
                        <v-tab href="#tab-2"> Decouvrir <v-icon>mdi-led-on</v-icon>
                        </v-tab>
                     </v-tabs>
                     <v-tabs-items v-model="tab">
                        <v-tab-item value="tab-1" style="width:100%">
                           <v-card elevation="4" width="100vw" min-height="200px" class="py-5">
                              <h3 class="text-center">
                               <?= empty($description)?'Aucune description':$description ?>
                              </h3>
                           </v-card>
                        </v-tab-item>
                        <v-tab-item value="tab-2" key="2">
                           <v-list nav width="100vw">
                              <v-list-item-group  color="blue">
                                 <?php foreach ($all_videos as $key => $value): ?>
                                 <?php
                                   $img_path=$table_videos->getImg($table_image,$value['id_img']);
                                    $img_path=$app->getImage("dailybreads",$img_path['path'],$img_path['extension']);

                                 ?>
                                 <v-list-item link
                                    <?= $_GET['id'] == $value["id"] ?'disabled':'' ?>
                                    href="<?=$_SERVER['PHP_SELF'].'?id='.$value['id'];?>&img_path=<?=$img_path?>" color="blue" key="<?=$key?>">
                                       <v-list-item-avatar>
                                          <v-img src="<?=$img_path?>"></v-img>
                                       </v-list-item-avatar>
                                       <v-list-item-title>
                                          <b> <?=$value['titre']?> </b>
                                       </v-list-item-title>
                                       <?php if ($_GET['id']==$value['id']): ?>
                                       <v-list-item-subtitle>Video en cours .....
                                       </v-list-item-subtitle>
                                       <v-list-item-action><v-icon>mdi-eye</v-icon>
                                       </v-list-item-action>
                                       <?php endif ?>
                                 </v-list-item>
                                 <?php endforeach ?>
                              </v-list-item-group>
                           </v-list>
                        </v-tab-item>
                     </v-tabs-items>
                  </v-card>
               </v-row>
            </v-container>
         </v-container>
      </v-main>
   </v-app>
</div>
<?php require 'includes/template.bottom.php' ?>
<script src="js/videoDetail.vuetify.js" defer=""></script>