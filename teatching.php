<?php
  if(!isset($_SESSION)) session_start();
  require 'class/Autoload.php';
  Autoload::register();
  $table_teatching = Table::getInstance()->get('teatching');
  $table_image = Table::getInstance()->get('image');
  $teatchings = $table_teatching->find();
  $app = App::getInstance();
 ?>
<?php require 'includes/template.head.php' ?>
<div id="app">
    <v-app>
        <v-app-bar app color="blue" short elevation="8">
            <v-app-bar-title>
                Teacthings
            </v-app-bar-title>
            <v-spacer></v-spacer>
            <v-icon>mdi-magnify</v-icon>
        </v-app-bar>
        <v-navigation-drawer perminent expand-on-hover app color="blue" class="lighten-2">
            <v-spacer></v-spacer>
            <br><br><br><br><br>
            <v-list link nav dense>
                <v-list-item-group color="red">
                  <v-list-item v-for="item in items" link :href="item.href">
                    <v-list-item-icon><v-icon>{{ item.icon }}</v-icon></v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        <v-main app>


  <v-container class="fill-height" fluid style="min-height: 434px">
    <v-fade-transition mode="out-in">
      <v-row>
      <?php foreach ($teatchings as $key => $value): ?>
        <?php $path_img = $table_teatching->getImg($table_image, $value['id_img']); ?>
        <v-col cols="12" md="4" height="35vh">
          <v-card link elevation="5" href='videoDetail.php?id=<?=$value["id"]?>&img_path=<?=$path_img['path'].".".$path_img['extension']?>'>
            <v-img
              src="<?=$app->getImage("dailybreads",$path_img['path'],$path_img['extension'])?>"
              contain
              height="35vh"
              class="grey darken-4"
            >
            <template v-slot:placeholder>
              <v-row class="fill-height ma-0" align="center" justify="center">
                <v-progress-circular
                  indeterminate
                  color="grey lighten-5"
                ></v-progress-circular>
              </v-row>
            </template>
            </v-img>
            <v-card-title class="text-h6">
              <?=$value['titre']?>
            </v-card-title>
          </v-card>
        </v-col>
      <?php endforeach ?>

      </v-row>
    </v-fade-transition>
  </v-container>

        </v-main>
        <v-footer app color="blue white--text" class="lighten-2">
            Living Intimacy with God and a Holy Transfiguration
        </v-footer>
    </v-app>
</div>
<?php require 'includes/template.bottom.php' ?>
<script src="js/teatching.vuetify.js" defer=""></script>