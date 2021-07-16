<?php
if(!isset($_SESSION)) session_start();
require_once '../Autoloader.php';
Autoloader::register();

$app = App::getInstance();
$table = Table::getInstance();
var_dump($app,$table);
?>

<?php
    require_once  '../template/template.head.php'
?>

<div id="app">
    <v-app>
        <v-app-bar app shrink-on-scroll dense class="light-blue">
            <v-app-bar-title class="font-weight-bold">Editer Le Daily.</v-app-bar-title>
        </v-app-bar>
        <v-main app>
            <v-container>
                <h1 class="text-center">
                    Bienvenu cher Admin
                </h1>
            </v-container>
        </v-main>

        <v-footer app dense class="light-blue white--text">
            <v-col cols="12" class="text-center font-weight-bold">
                Living  Intimacy With God and a Holy Tranfiguration
            </v-col>
        </v-footer>
    </v-app>
</div>

<?php
require_once  '../template/template.bottom.php'
?>
<script src="js/edit.vuetify.js" defer></script>

