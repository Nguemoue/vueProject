<?php
  if(!isset($_SESSION)) session_start();
  #je verifi si c'est la premiere fois que l'utilisateur navigue sur le site
    $isFirstStarted=false;
  if(isset($_COOKIE['isFirstStarted'])){
    $isFirstStarted = false;
  }else{
      setcookie('isFirstStarted',"true",time()+365*24*3600 ,null, null,false,true);
      $isFirstStarted = true;
  }
  require 'class/Autoload.php';
  Autoload::register();
  $databse = Database::getInstance();
  $config = Config::getInstance();
  $table_user = Table::getInstance()->get('users');
  $table_profil = Table::getInstance()->get('profil');
  $table_dailybreads = Table::getInstance()->get('dailybreads');
  $app = App::getInstance();
?>
<?php  require "includes/template.head.php" ?>
  <div id="app">
    <v-app>
       <!-- j'inclut mon appbar -->
       <?php if(!$isFirstStarted) require 'AppBar.php'; ?>

       <!-- j'inclut mon sidebar -->
       <?php if (!$isFirstStarted): ?>
          <?php require 'NavigationDrawer.php' ?>
       <?php endif ?>

        <v-main app>
         <!-- j'inclut le contenu du main -->
          <?php if($isFirstStarted):?>
            <?php require 'firstStarted.php' ?>
          <?php else: ?>
            <?php require 'Main.php' ?>
          <?php endif; ?>
      </v-main>
    </v-app>
  </div>
<?php  require "includes/template.bottom.php" ?>
<script src="js/index.vuetify.js" defer></script>
<script src="core.js"> </script>
</body>
</html>
