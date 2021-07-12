<!-- php page de traitement -->
<?php
#je demare ma session
if(!isset($_SESSION)) session_start();
require 'class/Autoload.php';
Autoload::register();
    $id = User::getId();
    $pdo = Database::getInstance()->getPdo();
    #si il y'a un destinataire
    $res=$pdo->query("SELECT contenu , create_at ,id_send from message where  id_receive = $id order by create_at desc");
        $msg_receive = $res->fetchAll();

    if(isset($_GET['id'])){
        /*
            1) je recupere tous les message que j'ai envoye chez lui
            2) je prend tout les messages qu'il a envoye
        */

        #tout les message que j'ai envoye chez lui
        $res=$pdo->query("SELECT contenu , create_at  from message where id_send = '$id' and id_receive = '$_GET[id]'");
        $msg_send = $res->fetchAll();

        #je recupere tout les message qu'il a envoyé chez moi
        $res=$pdo->query("SELECT contenu , create_at ,id_send from message where  id_receive = $id order by create_at desc");
        $msg_receive = $res->fetchAll();
    }
    // si on envoi le message
    if(isset($_GET['id']) and isset($_GET['message'])){
        #je peux envoyer mon message
        #je recupere mes info
        $id_receive = (int) $_GET['id'];
        $message = $_GET['message'];
        $prep = $pdo->prepare("INSERT into message set contenu = :contenu , create_at = NOW() , id_send = :id_send,id_receive = :id_receive");
        $prep->execute(['contenu'=>$message,'id_send'=>$id,'id_receive'=>$id_receive]);
        #je recupere tout les message qu'il a envoyé chez moi
     #tout les message que j'ai envoye chez lui
        $res=$pdo->query("SELECT contenu , create_at  from message where id_send = '$id' and id_receive = '$_GET[id]'");
        $msg_send = $res->fetchAll();

        #je recupere tout les message qu'il a envoyé chez moi
        $res=$pdo->query("SELECT contenu , create_at ,id_send from message where  id_receive = $id order by create_at desc");
        $msg_receive = $res->fetchAll();
    }



 ?>

<!-- j'inclut mon header template -->
<?php require 'includes/template.head.php' ?>
<div id="app">
    <v-app>
        <v-app-bar app short color="blue">
            <v-btn icon link href="<?= Helper::previousPage() ?>">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-app-bar-title>Rencontre</v-app-bar-title>
            <v-spacer></v-spacer>
            <?php if (User::connected()): ?>
            <v-btn text color="red">
                <v-icon left>mdi-account-off</v-icon>logout
            </v-btn>
            <?php endif ?>
        </v-app-bar>
        <v-main app>
            <v-container>
                <!-- j'affiche tous mes utilisateur connecté -->
                <?php if (User::connected()): ?>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-list nav bordered color="red" class="border-info lighten-2">
                            <v-subheader>Liste des personnes  à envoyer </v-subheader>
                        <v-list-group color="green" :value="<?=isset($_GET['id'])?'true':'false'?>">
                            <template #activator>
                                <v-list-item-title>Envoyer à</v-list-item-title>
                            </template>
                            <v-list-item-group color="blue"
                                :value="<?= (int) (isset($_GET['id'])?$_GET['id']:'-1') ?>" >
                                <?php foreach (Database::getInstance()->findAll() as $key => $value): ?>
                                <?php if ($value['id']==$id): ?>
                                    <v-list-item link href="encounters.php?id=<?=$value['id']?>" :disabled="true">
                                <v-list-item-avatar>
                                    <v-img alt="user"  src="<?=Database::getInstance()->getProfil($value['id']) ?>" origin="top top"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        Vous
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                                <?php else: ?>
                            <v-list-item link href="encounters.php?id=<?=$value['id']?>" >
                                <v-list-item-avatar>
                                    <v-img alt="user" src="<?=Database::getInstance()->getProfil($value['id']) ?>"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        <?=$value["nom"]?>
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        <?=$value["email"]?>
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        <?php endif ?>
                        <?php endforeach ?>
                            </v-list-item-group>
                        </v-list-group>
                        </v-list>
                    </v-col>
                    <v-col cols="12" md="6">
                        <?php if (isset($_GET['id'])): ?>
                        <v-card>
                            <v-toolbar color="blue">
                                <v-toolbar-title>Messages</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-divider vertical></v-divider>
                                <v-btn icon>
                                    <v-avatar>
                                        <img src="<?= Database::getInstance()->getProfil($_GET['id']) ?>" alt="">
                                    </v-avatar>
                                </v-btn>
                            </v-toolbar>

                            <v-card-text>
                                <p class="text-subtitle-1">
                                   envoyer un message en cliquanz sur le boutton envoyer
                                </p>
                            </v-card-text>

                            <v-footer>
                                <v-form style="width:100%" action="<?=$_SERVER['PHP_SELF']."?id=".$_GET['id']?>"
                                    method="get">
                                    <v-text-field append-icon="mdi-message" filled name="message"
                                        placeholder="your message" v-model="message" >
                                        <template #append-outer>
                                            <v-btn type="submit" icon>
                                                <v-icon>mdi-send</v-icon>
                                            </v-btn>
                                        </template>
                                    </v-text-field>
                                    <input type="hidden" name="id" value="<?=$_GET['id']?>">
                                </v-form>
                            </v-footer>
                        </v-card>
                        <?php endif ?>
                    </v-col>
                    <v-col cols="12" md="6" offset-md="6">
                        <v-dialog fullscreen hide-overlay transition="fade-transition" v-model="dialog">
                            <template #activator="{attr,on}">
                                <v-btn block large color="success" v-bind="attr" v-on="on" >
                                    Voir les messages reçu
                                    <v-icon right>mdi-message-text</v-icon>
                                </v-btn>
                            </template>
                            <v-card>
                                <v-toolbar color="blue" class="lighten-2">
                                    <v-toolbar-title>Message reçu</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn icon @click="dialog = false"><v-icon>mdi-close</v-icon></v-btn>
                                </v-toolbar>
                                <v-card flat>
                                    <v-container>
                                        <v-row>
                                    <?php if (empty($msg_receive)): ?>
                                        <p class="text-center">aucun message reçu</p>
                                    <?php else: ?>
                                        <v-list nav dense>
                                            <?php foreach ($msg_receive as $key => $value): ?>
                                                <v-list-item>
                                                    <v-list-item-avatar>
                                                        <img src="<?=Database::getInstance()->getProfil($value['id_send'])?>" alt="">
                                                    </v-list-item-avatar>
                                                    <v-list-item-content>
                                                        <v-list-item-title><?=$value['contenu']?></v-list-item-title>
                                                        <v-list-item-subtitle class="text-subtitle-2">le <?=$value['create_at']?></v-list-item-subtitle>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            <?php endforeach ?>
                                        </v-list>
                                    <?php endif ?>
                                </v-row>
                                    </v-container>
                                </v-card>
                            </v-card>
                        </v-dialog>
                    </v-col>
                </v-row>
                <?php else: ?>
                    <v-alert type="success" prominent>
                        Vous devez être connecté pour pouvoir débloquez ces focntionalité
                    </v-alert>
                    <br>
                    <v-alert type="success" prominent>
                        veuillez vous connectez ou vous inscrire
                    </v-alert>
                <?php endif; ?>
            </v-container>
        </v-main>
    </v-app>
</div>

<!-- j'inclut mon bottom template -->
<?php require 'includes/template.bottom.php'  ?>
<!-- j'inclut mon fichier de script -->
<script src="js/encounters.vuetify.js" defer=""></script>