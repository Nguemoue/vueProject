<?php
if(!isset($_SESSION)) session_start();
require_once '../Autoloader.php';
Autoloader::register();

$app = App::getInstance();
$table = Table::getInstance();
$table_dailybreads = $table->get('dailybreads');
$all = $table_dailybreads->find();
$taille = count($all);

?>

<?php
    require_once  '../template/template.head.php'
?>

<div id="app">
    <v-app>
        <v-app-bar app  class="light-blue">
            <v-btn icon href="../">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-app-bar-title class="font-weight-bold">Editer Le Daily.</v-app-bar-title>
        </v-app-bar>
        <v-main app>
            <v-container>
                <h1 class="text-center text-decoration-underline mb-5">
                    Bienvenu cher Admin
                </h1>
                <hr>
                <v-col cols="12" align="right">
                    <b>Ajouter Un Nouveau</b>
                    <v-btn color="success">
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </v-col>
                <?php if (empty($all)): ?>
                    <h1>
                        Aucun Daily Bread Disponible
                    </h1>
                <?php else: ?>
                <v-simple-table class="my-5">
                    <template #default>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Date Publication</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($all as $key => $value): ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $value['nom'] ?></td>
                                    <td><?= $value['create_at'] ?></td>
                                    <td>
                                        <v-menu transition="scale-transition" offset-y bottom>
                                            <template #activator="{attrs,on}">
                                                <v-btn color="success" v-bind="attrs" v-on="on" class="md12">    Options
                                                    <v-icon right >mdi-chevron-down</v-icon>
                                                </v-btn>
                                            </template>
                                            <v-sheet>
                                                <v-container>
                                                    <v-btn block color="primary">
                                                    Editer
                                                    <v-icon right>mdi-pencil</v-icon>
                                                </v-btn>
                                                <br>
                                                <v-btn block color="error">
                                                    Supprimer
                                                    <v-icon right>mdi-delete</v-icon>
                                                </v-btn>
                                                </v-container>
                                            </v-sheet>
                                        </v-menu>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="3" class="text-h5">
                                    Nombres Total
                                </td>
                                <td class="text-center text-h5" >
                                    <span class="font-weight-bold red--text"><?= $taille ?></span>
                                </td>
                            </tr>
                        </tbody>



                    </template>
                </v-simple-table>
                <?php endif ?>
            </v-container>
        </v-main>

    </v-app>
</div>

<?php
require_once  '../template/template.bottom.php'
?>
<script src="js/index.vuetify.js" defer></script>

