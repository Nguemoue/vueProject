<?php
    // le traitement php s'effectue ici
    if(!isset($_SESSION)) session_start();
    require 'class/Autoload.php';
    Autoload::register();
    $app = App::getInstance();
    $table = Table::getInstance();
    $table_videos = $table->get('videos');
    $table_user = $table->get('users');
    $table_image = $table->get('image');
    $table_encounter = $table->get('encounter');

    $all_encounter = $table_encounter->find();
?>
<?php require 'includes/template.head.php'; ?>

<div id="app">
  <v-app>
    <v-app-bar app color="blue" short elevation="8">
        <v-app-bar-title>
            Encounter
        </v-app-bar-title>
        <v-spacer></v-spacer>
        <v-icon>mdi-magnify</v-icon>
    </v-app-bar>
    <v-navigation-drawer perminent expand-on-hover app color="blue" class="lighten-2">
        <v-spacer></v-spacer>
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
      <v-container>
        <h1 class="text-center">Liste Des Encounters</h1>
        <v-row>
          <?php foreach ($all_encounter as $key => $value): ?>
            <?php $path_img = $table_encounter->getImg($table_image, $value['id_img']); ?>
            <v-col cols="12" md="4" height="35vh">
              <v-card link elevation="5" href='EncounterDetail.php?id=<?=$value["id"]?>'>
                <v-img
                  src="<?=$app->getImage("dailybreads",$path_img['path'].".".$path_img['extension'])?>"
                  contain height="35vh" class="grey darken-4">
                  <template v-slot:placeholder>
                    <v-row class="fill-height ma-0" align="center" justify="center">
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
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
      </v-container>
    </v-main>
    <v-footer app color="blue white--text" class="lighten-2">
      Living Intimacy with God and a Holy Transfiguration
    </v-footer>
  </v-app>
</div>



<?php require 'includes/template.bottom.php'; ?>
<script src="js/encounter.vuetify.js" defer></script>


