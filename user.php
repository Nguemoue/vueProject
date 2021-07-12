<?php
    #je demare ma session
    if(!isset($_SESSION)) session_start();
    # je require mon autoload
    require 'class/Autoload.php';
    Autoload::register();
    #je gere mes donnnes posté
    $table_user = Table::getInstance()->get('users');
    $table_profil = Table::getInstance()->get('profil');
    $app = App::getInstance();

    if(!empty($_POST)){
        #je verifie si il clique sur sauvegarde
        $validator = new Validator();
        if(isset($_POST['sauvegarder'])){

            #je verifie mes champs
            $validator->validateNom($_POST['nom']);
            $validator->validateVille($_POST['ville']);
            $validator->validateVille($_POST['pays']);
            $validator->validateTel($_POST['tel']);

            #je verifie si cette adresse n'est pas presente dans la base de donnes
            if(!$validator->hasError()){
                #je recupere mes donnees
                $nom = $_POST['nom'];
                $ville = $_POST['ville'];
                $pays = $_POST['pays'];
                $password = $_POST['password'];
                $tel = $_POST['tel'];
                $auth = $_SESSION['auth'];
                #je met a jour mes donnees et je lui réenvoi un code d'activation
               $res= $table_user->update(['nom'=>$nom,'ville'=>$ville,'pays'=>$pays,'password'=>$password,'tel'=>$tel],"where email = '$auth'");
                #j'affiche un message de succes
               if($res){
                $operation_success = true;
               }
            }

        }else if(isset($_POST['profil'])){
            $validator->ValidateImg($_FILES['image_profil']);
            if(!$validator->hasError()){
                #je recupère mon id de l'utilisateur
                $id_user = $table_user->getId();

                #je recupere les info a mettre a jour
                $nom_img = $app->generateFileName($table_user->getNom());
                $extension = pathinfo($_FILES['image_profil']['name'])['extension'];
                #j'execute ma mise a jour
                unlink($table_user->getProfil($table_profil));
                $res = $table_user->updateProfil($table_profil,['nom'=>$nom_img,
                    'extension'=>$extension,'update_at'=>'NOW()']);
                #je upload mon nouveau fichier
                $app->uploadFile($_FILES['image_profil']['tmp_name'],$nom_img.'.'.$extension,"profil");
                $operation_success = true;
            }
        }else if(isset($_POST['destroy'])){
                #je recupere mon id de l'utilisateur
                $id_user = $table_user->getId();
                #je supprime son image de profil
                unlink($table_user->getProfil($table_profil));
                #je supprime son profil
                $table_user->deleteProfil($table_profil);
                #je supprime l'utilisateur
                $table_user->delete("where id = $id_user");
                session_destroy();
                header("Location:index.php");
            }
    }

?>

<?php require 'includes/template.head.php' ?>
<div id="app">
    <v-app>
        <!-- mon appbar -->
        <v-app-bar app color="blue">
            <v-btn icon href="<?= Helper::previousPage() ?>">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-app-bar-title>Account</v-app-bar-title>
            <v-spacer></v-spacer>
            <?php if ($app->isConnected()): ?>
                <v-btn  color="red" dense href="logout.php" class="text-subtitle-2">
                    logout
                    <v-icon right color="white">mdi-account-remove</v-icon>
                </v-btn>
            <?php else: ?>
                <v-btn  color="white"  text href="inscription.php">
                    S'inscrire
                    <v-icon right>mdi-account-plus</v-icon>
                </v-btn>
                <v-divider vertical></v-divider>
                <v-btn color="red" text href="connexion.php">
                    login
                    <v-icon right>mdi-account-arrow-left</v-icon>
                </v-btn>
            <?php endif ?>
        </v-app-bar>

        <!-- mon main -->
        <v-main app>
            <!-- mon container qui vas contenir le breadcrumb-->
            <v-container>
                <v-row align="center">
                    <v-col cols="12">
                        <v-breadcrumbs :items="breadcrumbs">
                            <template #divider>
                                <v-icon>mdi-forward</v-icon>
                            </template>
                        </v-breadcrumbs>
                    </v-col>
                </v-row>
            </v-container>

            <!-- je cree un container qui vas contenir les messages relatif aux modifications -->
            <?php if($app->isConnected()): ?>
                <v-container>

                    <!-- je creer ma row pour afficher mes erreurs mes erreurs -->
                    <v-row>    
                    <!-- j'affiche mon message de success -->
                        <?php if((isset($_POST['sauvegarder']) or isset($_POST['profil'])) 
                            and isset($operation_success) ): ?>

                        <v-col cols="12">
                            <v-alert type="info" prominent >
                            Vos Donnés ont été correctement mis à jour
                            </v-alert>
                        </v-col>
                        <?php endif ?>
                    <!-- j'affiche mes message d'erreurs -->
                        <?php if ((isset($_POST['sauvegarder']) or isset($_POST['profil']))): ?>
                            <?php if ($validator->hasError()): ?>
                                <v-alert type="error" prominent dismissible>
                                    <ol class="list-group list-unstyled">
                                        <?php foreach ($validator->getErrors() as $key => $value): ?>
                                            <li class="text-center"><?=$value?></li>
                                        <?php endforeach ?>
                                    </ol>
                                </v-alert>
                            <?php endif ?>
                        <?php endif ?>
                    </v-row>    

                    <!-- j'affiche mon message d'introduction-->
                    <p>
                        <h1 class="text-center text-subtitle-1 text-md-h4 ">
                            Content de Vous Retrouvez 
                            <b class="text-decoration-underline">
                                <?= $table_user->getNom() ?>
                            </b>
                        </h1>
                    </p>
                    <!-- le card qui affiche differents options a effectuer sur mon compte -->
                    <v-card>
                        <v-toolbar color="red lighten-3">
                            <v-toolbar-title class="font-weight-bold text-subtitle-2">Actions Sur Mon compte
                            </v-toolbar-title>
                        </v-toolbar>
                        <v-card flat class="py-4 px-2">
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="12" md="4" lg="4">
                                       <v-dialog v-model="Sdialog" fullscreen hide-overlay            transition="dialog-bottom-transition">
                                           <template v-slot:activator="{ on, attrs }">
                                               <v-btn block large color="blue darken-2"
                                                    v-bind="attrs" v-on="on" class="text-truncate">
                                                    modifier mes données
                                                <v-icon right>mdi-account-cog</v-icon>
                                                </v-btn>
                                            </template>
                                            <v-card>
                                                <v-toolbar dark color="primary">
                                                    <v-btn icon dark @click="Sdialog = false">
                                                        <v-icon>mdi-close</v-icon>
                                                    </v-btn>
                                                    <v-toolbar-title>Modifications</v-toolbar-title>
                                                    <v-spacer></v-spacer>
                                                    <v-btn text dense small>
                                                        <?= $_SESSION['auth']?>
                                                    </v-btn>
                                                </v-toolbar>
                                                <v-container>
                                                    <h1 class="text-center">
                                                        Modifier Vos Information
                                                    </h1>
                                                    <p>
                                                        <v-alert type="info" outlined dismissible>
                                                            apuyer sur sauvegarder pour mettre à jour vos données
                                                        </v-alert>
                                                    </p>
                                                    <v-form method="post" v-model="model.modification" action="<?=$_SERVER['PHP_SELF']?>">
                                                    <?php  $data = $table_user->select(['nom','ville','pays','password','tel'],"where id = ".$table_user->getId());?>

                                                    <?php foreach($data as $key=>$value):?>
                                                    <v-text-field label="<?=$key?>" name="<?=$key?>" value="<?=$value?>" filled :rules="<?='rules.'.$key?>"></v-text-field>
                                                    <?php endforeach ?>
                                                    <v-btn :disabled="!model.modification" color="success" type="submit" name="sauvegarder">
                                                        Sauvegarder
                                                        <v-icon right>mdi-download-network</v-icon>
                                                    </v-btn>
                                                </v-form>
                                                </v-container>
                                            </v-card>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols="12" sm="12"  md="4" lg="4">

                                        <v-dialog v-model="dialog" fullscreen hide-overlay            transition="dialog-bottom-transition">
                                           <template v-slot:activator="{ on, attrs }">
                                               <v-btn large block color="green" v-bind="attrs" v-on="on" class="text-subtitle-2">
                                                Changer Mon Profil
                                            <v-icon right>mdi-account-edit</v-icon>
                                        </v-btn>
                                            </template>
                                            <v-card>
                                                <v-toolbar dark color="primary">
                                                    <v-btn icon dark @click="dialog = false">
                                                        <v-icon>mdi-close</v-icon>
                                                    </v-btn>
                                                    <v-toolbar-title>Profil Update</v-toolbar-title>
                                                    <v-spacer></v-spacer>
                                                    <v-btn text dense small>
                                                        <?= $_SESSION['auth']?>
                                                    </v-btn>
                                                </v-toolbar>
                                                <v-container>
                                                    <h1 class="text-center">
                                                        Modifier Votre Profil
                                                    </h1>
                                                    <p>
                                                        <v-alert type="info" outlined dismissible>
                                                            apuyer sur sauvegarder pour mettre à jour vos données
                                                        </v-alert>
                                                    </p>
                                                    <v-container>
                                                        <v-row>
                                                        <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                                                            <h1>
                                                                <v-subheader>Votre Photo de Profil Actuele</v-subheader>
                                                                <v-img src="<?=$table_user->getProfil($table_profil)?>" height="50vh" contain></v-img>
                                                            </h1>
                                                        </v-col>

                                                        <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                                                        <br><br><hr><br><br>
                                                    <v-form method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" v-model="model.profil">
                                                        <v-subheader>Choisissez Votre Nouvelle photo de profil</v-subheader>
                                                         <v-file-input accept="image/*" chips counter name="image_profil" v-model="model.file"
                                                         prepend-icon=""
                                            label="Nouvelle Photo" :rules="rules.file" prepend-inner-icon="mdi-camera" dense filled truncate-length="50" class="text-truncate">
                                        </v-file-input>
                                                    <v-btn large block color="success" type="submit"
                                                        name="profil" :disabled="!model.profil">
                                                        Enregistrez
                                                        <v-icon right>mdi-account-edit</v-icon>
                                                    </v-btn>
                                                </v-form>
                                                        </v-col>
                                                    </v-row>
                                                    </v-container>
                                                </v-container>
                                            </v-card>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="4" lg="4">
                                        <v-dialog v-model="DDialog">
                                                <template #activator="{on,attrs}">

                                        <v-btn block v-bind="attrs" v-on="on"  large color="red lighten-2">Supprimer Mon Compte
                                            <v-icon right>mdi-account-remove</v-icon>
                                        </v-btn>
                                                </template>
                                                <v-form method="post" action="<?=$_SERVER['PHP_SELF']?>">
                                                    <v-card color="info" class="blue" backgroundColor="#ccc">
                                                        <v-toolbar color="red">
                                                          <v-toolbar-title>Delete Account</v-toolbar-title>
                                                          <v-spacer></v-spacer>
                                                          <v-btn icon @click="DDialog = false">
                                                                <v-icon>mdi-close</v-icon>
                                                        </v-btn>
                                                        </v-toolbar>
                                                        <v-card flat>
                                                                <h1 class="text-center">
                                                                Voulez Vous Supprimer votre compte definitivement?
                                                        </h1>
                                                        <v-subheader class="text-center">
                                                            en le supprimant vous ne pouvez plus vous connecté
                                                        </v-subheader>
                                                        </v-card>
                                                    </v-card>

                                                        <v-card color="info">

                                                            <v-btn large  color="red" type="submit" name="destroy" class="px-5 mx-5">Oui
                                                            <v-icon right>mdi-delete</v-icon></v-btn>
                                                                <v-btn large class="float-right px-5 mx-5" color="green" @click.stop="DDialog = false">Non
                                                                <v-icon icon>mdi-close</v-icon> </v-btn>
                                                        </v-card>
                                                </v-form>
                                        </v-dialog>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                    </v-card>

                    <!-- card qui affiche les options sur mon compte -->
                    <br><br>
                    <v-card>
                        <v-toolbar color="green lighten-2">
                            <v-toolbar-title class="font-weight-bold text-subtitle-2">
                                Vos Informations Personnels
                            </v-toolbar-title>
                        </v-toolbar>
                        <?php $user_data = $table_user->getData();?>
                        <v-card flat>
                            <v-list nav>
                                <v-list-group>
                                    <template #activator>
                                        <v-col cols="12" md="10" sm="12">
                                            <v-list-item>
                                                    <v-list-item-avatar>
                                                <v-img src="<?=$table_user->getProfil($table_profil)?>" color="red" contain></v-img>
                                            </v-list-item-avatar>
                                            <v-list-item-title class="font-weight-bold">
                                                Voir Mes  Données
                                            </v-list-item-title>
                                            </v-list-item>
                                        </v-col>
                                    </template>
                                    <v-list  :value="1" nav dense>
                                        <?php foreach ($user_data as $key => $value): ?>
                                            <v-list-item>
                                                <v-row>
                                                    <v-col cols="6" class="text-truncate"><b class="">
                                                        <?=$key?></b></v-col>
                                                    <v-col cols="6" class="text-truncate"><?= $value ?></v-col>
                                                    <hr>
                                                </v-row>
                                            </v-list-item>
                                        <?php endforeach ?>
                                    </v-list>
                                </v-list-group>
                            </v-list>
                        </v-card>
                    </v-card>
                </v-container>
            <!-- dans le cas ou l'utilisateur ne possede pas de compte -->
            <?php else: ?>
                <v-container>
                    <h1 class="text-center">Bienvenue Cher Utilisateur</h1>
                    <hr><br>
                    <p class="text-center">
                        <v-alert type="info" prominent dismissible transition="fade-transition" class="text-subtitle-2 font-weight-bold darken-2 text-sm-subtitle-1 text-md-h6">
                             connectez vous ou identifiez vous selon les règles qui suivent
                        </v-alert>
                    </p>
                    <br><hr><br>
                    <!-- j'affiche mes card qui vont lui permetre de choisir -->
                    <v-row>
                        <!-- colone de connexion -->
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                            <v-hover v-slot="{hover}" hide-delay="100" open-delay="200">
                                <v-card :elevation="hover?24:1" class="{'on-hover':hover}">
                                    <v-toolbar color="blue" class="lighten-4">
                                        <v-toolbar-title class="text-center">
                                            Connectez-Vous
                                        </v-toolbar-title>
                                    </v-toolbar>
                                    <v-card-content>
                                        <v-container>
                                            <v-sheet>
                                                <ol class="font-weight-bold">
                                                    <li>Si vous vous avez déja un compte </li>
                                                    <li>voulez vous voir les dernieres news?</li>
                                                    <li>  voulez vous vous identifier?</li>
                                                </ol>
                                            </v-sheet>
                                        </v-container>
                                    </v-card-content>
                                    <v-divider> </v-divider>
                                    <v-card-actions class="red lighten-3">
                                        <v-btn class="text-center" color="blue" link href="connexion.php">
                                            Se Connecter
                                            <v-icon right>mdi-account-arrow-left</v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-hover>
                        </v-col>
                        <!-- colone d'inscription -->
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                            <v-hover v-slot="{hover}" hide-delay="100" open-delay="200">
                                <v-card :elevation="hover? 24:1" :class="{'on-hover':hover}">
                                    <v-toolbar color="green" class="lighten-4">
                                        <v-toolbar-title class="text-center">
                                            Inscrivez Vous
                                        </v-toolbar-title>
                                    </v-toolbar>
                                    <v-card-content>
                                        <v-container>
                                            <v-sheet>
                                                <ol class="font-weight-bold">
                                                    <li>Si vous ne vous êtes pas encore inscrit <br></li>
                                                    <li> debloquez toutes les fonctionalités de l'application</li>
                                                    <li>une assistance plus poussé?</li>
                                                </ol>
                                            </v-sheet>
                                        </v-container>
                                    </v-card-content>
                                    <v-divider> </v-divider>
                                    <v-card-actions class="red lighten-3">
                                        <v-btn color="green" href="inscription.php">
                                            S'inscrire
                                            <v-icon right>mdi-account-plus</v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-hover>
                        </v-col>
                    </v-row>
                </v-container>
            <?php endif ?>
        </v-main>
    </v-app>
</div>
<?php require 'includes/template.bottom.php' ?>
<script src="js/user.vuetify.js" defer="" ></script>
