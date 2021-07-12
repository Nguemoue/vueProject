[33mcommit a337d847449ad851d0fdfbfd1a1c76d77927c0dd[m
Author: Luc <nguemoueluc@gmail.com>
Date:   Mon Jul 12 03:07:14 2021 +0100

    premiere modification dans le code

[1mdiff --git a/index.php b/index.php[m
[1mnew file mode 100644[m
[1mindex 0000000..cfa8282[m
[1m--- /dev/null[m
[1m+++ b/index.php[m
[36m@@ -0,0 +1,45 @@[m
[32m+[m[32m<?php[m
[32m+[m[32m  if(!isset($_SESSION)) session_start();[m
[32m+[m[32m  #je verifi si c'est la premiere fois que l'utilisateur navigue sur le site[m
[32m+[m[32m    $isFirstStarted=false;[m
[32m+[m[32m  if(isset($_COOKIE['isFirstStarted'])){[m
[32m+[m[32m    $isFirstStarted = false;[m
[32m+[m[32m  }else{[m
[32m+[m[32m      setcookie('isFirstStarted',"true",time()+365*24*3600 ,null, null,false,true);[m
[32m+[m[32m      $isFirstStarted = true;[m
[32m+[m[32m  }[m
[32m+[m[32m  require 'class/Autoload.php';[m
[32m+[m[32m  Autoload::register();[m
[32m+[m[32m  $databse = Database::getInstance();[m
[32m+[m[32m  $config = Config::getInstance();[m
[32m+[m[32m  $table_user = Table::getInstance()->get('users');[m
[32m+[m[32m  $table_profil = Table::getInstance()->get('profil');[m
[32m+[m[32m  $table_dailybreads = Table::getInstance()->get('dailybreads');[m
[32m+[m[32m  $app = App::getInstance();[m
[32m+[m[32m?>[m
[32m+[m[32m<?php  require "includes/template.head.php" ?>[m
[32m+[m[32m  <div id="app">[m
[32m+[m[32m    <v-app>[m
[32m+[m[32m       <!-- j'inclut mon appbar -->[m
[32m+[m[32m       <?php if(!$isFirstStarted) require 'AppBar.php'; ?>[m
[32m+[m
[32m+[m[32m       <!-- j'inclut mon sidebar -->[m
[32m+[m[32m       <?php if (!$isFirstStarted): ?>[m
[32m+[m[32m          <?php require 'NavigationDrawer.php' ?>[m
[32m+[m[32m       <?php endif ?>[m
[32m+[m
[32m+[m[32m        <v-main app>[m
[32m+[m[32m         <!-- j'inclut le contenu du main -->[m
[32m+[m[32m          <?php if($isFirstStarted):?>[m
[32m+[m[32m            <?php require 'firstStarted.php' ?>[m
[32m+[m[32m          <?php else: ?>[m
[32m+[m[32m            <?php require 'Main.php' ?>[m
[32m+[m[32m          <?php endif; ?>[m
[32m+[m[32m      </v-main>[m
[32m+[m[32m    </v-app>[m
[32m+[m[32m  </div>[m
[32m+[m[32m<?php  require "includes/template.bottom.php" ?>[m
[32m+[m[32m<script src="js/index.vuetify.js" defer></script>[m
[32m+[m[32m<script src="core.js"> </script>[m
[32m+[m[32m</body>[m
[32m+[m[32m</html>[m
