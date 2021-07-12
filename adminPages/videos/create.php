<!-- j'inclut mon tmplate head -->
<?php
   if(!isset($_SESSION)) session_start();
   define( "TEMPLATE_ROOT",(dirname(dirname(__FILE__)))."\\template\\" );
   #j'inclut mon autloader
   require '../Autoloader.php';
   Autoloader::register();
   $validator = new Validator();
   $app = App::getInstance();
   $table_image = Table::getInstance()->get('image');
   $table_videos = Table::getInstance()->get('videos');
   $table_user = Table::getInstance()->get('users');
   $table_admin = Table::getInstance()->get('administrateur');
   if(!empty($_POST)){
      # je passe à la verification
      $validator->validateNom($_POST['nom']);
      $validator->validateNom($_POST['titre']);
      // $validator->validateNom($_POST['description']);
      $validator->ValidateImg($_FILES['img']);
      $validator->ValidateVideo($_FILES['video']);
      var_dump($validator);#die();
      #je continue si il n'ya aucune erreur
      if(!$validator->hasError()){
         #j'insere ma video
         $pdo = Database::getInstance()->getPdo();

         #je traite les donnes necessaires
         $extension_video = pathinfo($_FILES['video']['name'])['extension'] ;
         $extension_img = pathinfo($_FILES['img']['name'])['extension'];
         $path_img = $app->generateFileName($_POST['nom']);
         $path_video = $app->generateFileName($_POST['nom']);

         #j'insere mon image dans la base de donne
         $table_image->insert(['path'=>$path_img,'extension'=>$extension_img,'id_post'=>$table_user->getId(),'create_at'=>'NOW()']);
         #je recupere l'id de la derniere image inser
         $id_image = $table_image->getLastId();
         $id_admin = $table_admin->getIdByUser($table_user);

         #j'insert ma video
         $table_videos->insert(['categorie'=>$_POST['categorie'],'nom'=>$_POST['nom'],'titre'=>
            $_POST['titre'],'path'=>$path_video,'extension'=>$extension_video,'id_admin'=>
               $id_admin,'id_img'=>$id_image,'description'=>$_POST['description'],'create_at'=>'NOW()']);

         # je deplace mes fichiers cree vers leur dossier respectif
         $app->uploadFile($_FILES['img']['tmp_name'],$path_img.".".$extension_img,"dailybreads");
         $app->uploadFile($_FILES['video']['tmp_name'],$path_video.".".$extension_video,"all_cat");
         $operation_success = true;
      }

   }

?>
<?php require(TEMPLATE_ROOT."template.head.php"); ?>

<div id="app">
  <v-app>
    <v-app-bar app color="blue" short>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-app-bar-title>
         Create Videos
      </v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn icon href="../../">
         <v-icon>mdi-home</v-icon>
      </v-btn>
   </v-app-bar>
   <v-main app>
      <v-container>
         <!-- je cree mon formulaire -->
         <v-card >
            <v-toolbar  color="deep-purple" class="text-center white--text lighten-1">
                  <v-toolbar-title  > Enregistrez De  Nouveau Medias (Prayer Line , Teatching , Encounters ...)<br></v-toolbar-title>
            </v-toolbar>
            <v-form class="px-3 py-3" method="post" action="<?= $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
               <?php if ($validator->hasError()): ?>
                  <v-alert type="error" prominent>
                     <ol class="list-unstyled">
                        <?php foreach ($validator->getErrors() as $key => $value): ?>
                           <li><?= $value ?></li>
                        <?php endforeach ?>
                     </ol>
                  </v-alert>
               <?php endif ?>
               <?php if (isset($operation_success)): ?>
                  <v-alert type="success" prominent ><?= $_POST['categorie'] ?> Enregistré avec success</v-alert>
               <?php endif ?>
               <div>
                  <v-select filled chips label="Categories" :items="items.categorie" v-model="model.categorie" dense name="categorie">
                  </v-select>
               </div>
               <div>
                  <v-text-field name="nom" :label="`Nom ${type}`" filled dense> </v-text-field>
               </div>
               <div>
                     <v-text-field name="titre" :label="`Titre ${type}`" filled clearable>
                     </v-text-field>
               </div>
               <div>
                  <v-file-input show-size chips truncate filled prepend-icon="" prepend-inner-icon="mdi-image" counter
                  :label="`Image De Garde ${type}`" accept="image/*" clearable name="img"> </v-file-input>
               </div>
               <div>
                  <v-file-input show-size chips truncate filled prepend-icon=""
                     prepend-inner-icon="mdi-video" counter name="video" accept="video/*"
                  :label="`Choisissez le contenu ${type}`">
                  </v-file-input>
               </div>
               <div>
                  <v-textarea filled :label="`Description  ${type}`" clearable name="description"> </v-textarea>
               </div>
               <div>
                  <v-col cols="6">
                        <v-btn type="submit" color="success" block large>Enregsitrez
                           <v-icon right>mdi-check</v-icon>
                        </v-btn>
                  </v-col>
               </div>
            </v-form>
         </v-card>
      </v-container>
   </v-main>
   <v-footer app color="blue" class="white--text text-center" >
         <v-row >
            <v-col cols="12">
               Living Intimacy with God And a Holy Transfiguration
            </v-col>
         </v-row>
   </v-footer>
</v-app>
</div>




<!-- j'inclut mon navigation bootom -->
<?php  require TEMPLATE_ROOT."template.bottom.php"?>
<!-- mon fichier js -->
<script src="js/create.vuetify.js" defer=""></script>