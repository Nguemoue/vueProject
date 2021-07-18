<?php
#je demmare ma session
if (!isset($_SESSION)) session_start();
#j'inclut mon  autoloader  et je lance mon autoloader
spl_autoload_register("autoload")

$table_dailybreads = Table::getInstance()->get('dailybreads');
$table_user = Table::getInstance()->get('users');
$table_administrateur = Table::getInstance()->get('administrateur');
$table_user = Table::getInstance()->get('users');
$app = App::getInstance();
$id_user = $table_user->getId();
$id_admin = $table_administrateur->getIdByUser($table_user);
$nom = $table_administrateur->getNom($table_user,$id_admin);
#je verifie si il est amdin
if (!$app->isAdmin($table_user)) {
   die("vous n'avez pas assez a cette page : <a href='../../'>retour</a>");
}
?>
<?php require 'template/template.head.php'; ?>
<div id="app">
    <v-app>
        <v-app-bar color="red" app short>
            <v-app-bar-nav-icon>
                <template #default>
                    <v-icon>mdi-account</v-icon>
                </template>
            </v-app-bar-nav-icon>
            <v-app-bar-title>Admin.</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn text small color="white" flat tile tag="span">
                <span class="text-lowercase" class="white--text"><?=$table_user->getEmail()?></span>
            </v-btn>
            <v-expand-x-transition>
                <v-btn icon @click="drawer=!drawer" v-if="!drawer">
                    <v-icon>mdi-menu</v-icon>
                </v-btn>
                <v-btn icon @click="drawer=!drawer" v-else>
                    <v-icon>mdi-menu-open</v-icon>
                </v-btn>
            </v-expand-x-transition>
        </v-app-bar>
        <v-navigation-drawer app color="blue" v-model="drawer" right class="lighten-4">
            <v-toolbar color="blue">
                <v-toolbar-title>Options</v-toolbar-title>
            </v-toolbar>
        </v-navigation-drawer>

        <v-main app color="violet" class="violet" active-class="violet">
            <v-container color="violet">
                <h1 class="text-center mb-4">
                    Bienvenue <b class=""><?= $nom?> </b>
                </h1>
                <hr>
                <br>
                <v-row>
                    <!-- la colonne des daily breads -->
                    <v-col>
                        <v-card elevation="4">
                            <v-toolbar>
                                <v-toolbar-title>Daily Bread</v-toolbar-title>
                            </v-toolbar>
                            <v-card>
                                <v-container>
                                    <v-row>
                                        <v-col>
                                            <v-btn color="success" block large href="adminPages/dailyBreads/create.php">
                                                <v-icon left>mdi-image-plus</v-icon>
                                                Ajouter
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn color="info" block large href="adminPages/dailyBreads/edit.php">
                                                <v-icon left>mdi-image-edit</v-icon>
                                                Editer
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn color="error" block large href="adminPages/dailyBreads/delete.php">
                                                <v-icon left>mdi-image-remove</v-icon>
                                                Supprimer
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card>
                        </v-card>
                    </v-col>
                    <!-- la colone des soaking workship -->
                    <v-col>
                        <v-card elevation="4">
                            <v-toolbar>
                                <v-toolbar-title>Soaking Worhsip</v-toolbar-title>
                            </v-toolbar>
                            <v-card>
                                <v-container>
                                    <v-row>
                                        <v-col>
                                            <v-btn color="success" block large>
                                                <v-icon left>mdi-music-note-plus</v-icon>
                                                Ajouter
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn color="info" block large>
                                                <v-icon left class="edit">mdi-playlist-edit</v-icon>
                                                Editer
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn color="error" block large>
                                                <v-icon left class="">mdi-music-off</v-icon>
                                                Supprimer
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card>
                        </v-card>
                    </v-col>
                    <!-- la colone des videos -->
                    <v-col>
                        <v-card elevation="4">
                            <v-toolbar>
                                <v-toolbar-title>Videos</v-toolbar-title>
                            </v-toolbar>
                            <v-card>
                                <v-container>
                                    <v-row>
                                        <v-col>
                                            <v-btn color="success" block large href="adminPages/videos/create.php">
                                                <v-icon left class="" size="30">mdi-video-plus-outline</v-icon>
                                                Ajouter
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn color="info" block large href="adminPages/videos/edit.php">
                                                <v-icon left>mdi-pencil</v-icon>
                                                Editer
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn color="error" block large href="adminPages/videos/delete.php">
                                                <v-icon left class="">mdi-video-off-outline</v-icon>
                                                Supprimer
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card>
                        </v-card>
                    </v-col>
                    <!-- je gere la partie utilisateur -->
                    <v-col>
                        <v-card elevation="4">
                            <v-toolbar>
                                <v-toolbar-title>Utilisateur</v-toolbar-title>
                            </v-toolbar>
                            <v-card>
                                <v-container>
                                    <v-row>
                                        <v-col>
                                            <v-btn color="info" block large href="adminPages/users/create.php">
                                                <v-icon left class="edit">mdi-playlist-edit</v-icon>
                                                Ajouter Un Administrateur
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn color="error" block large href="adminPages/users/delete.php">
                                                <v-icon left class="">mdi-account-off</v-icon>
                                                Bloquer Un Utilisateur
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
        <v-footer app align="center" class="text-center font-weight-black" bottom float>
            <v-container class="text-center">copyright &copy L.I.G.H.T tout droit réservé;</v-container>
        </v-footer>
    </v-app>
</div>
<?php require 'template/template.bottom.php'; ?>
<script src="js/administrateur.vuetify.js" defer=""></script>
