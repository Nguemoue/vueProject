<!-- j'inclut mon tmplate head -->
<?php
   if(!isset($_SESSION)) session_start();
   define( "TEMPLATE_ROOT",(dirname(dirname(__FILE__)))."\\template\\" );
   #j'inclut mon templte header
   #j'inclut mon autloader
   require '../Autoloader.php';
   Autoloader::register();
   $validator = new Validator();
   $table_dailybreads = Table::getInstance()->get('dailybreads');
   $table_user= Table::getInstance()->get('users');
   $app = App::getInstance();
   $id = $table_user->getId();
   #je verifie si il est amdin
   if(!$app->isAdmin($table_user)){
      die("vous n'avez pas assez a cette page : <a href='../../'>retour</a>");
   }
   if(!empty($_POST)){
      $validator->validateImg($_FILES['img']);
   $validator->validateNom($_POST['nom']);
   $validator->validateNom($_POST['titre']);
   if(!$validator->hasError()){
      #j'enreistre mes donnes dans ma tables
      #je cree le path
      $extension = pathinfo($_FILES['img']['name'])['extension'];
      $path = $app->generateFileName($_POST['nom']);
      $table_dailybreads->insert(['nom'=>$_POST['nom'],'titre'=>$_POST['titre'],'path'=>$path,'extension'=>$extension,'description'=>$_POST['description'],'id_post'=>$id,'create_at'=>'NOW()']);
      $app->uploadFile($_FILES['img']['tmp_name'],$path.".".$extension , "dailybreads");
      $operation_success = true;

   }

   }
?>
<?php require(TEMPLATE_ROOT."template.head.php"); ?>

<div id="app">
  <v-app>
    <v-app-bar app>
      <v-app-bar-nav-icon>
         <template #default>
            <v-icon class="">mdi-account</v-icon>
         </template>
      </v-app-bar-nav-icon>
      <v-app-bar-title>
         Daily Breads
      </v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn icon href="../../">
         <v-icon>mdi-home</v-icon>
      </v-btn>
   </v-app-bar>
   <v-main app>
      <v-container>
         <h1 class="text-center teal--text font-weight-bold text-capitalize text-decoration-underline">Info Sur Le Daily Breads</h1>
            <v-card>
               <v-toolbar>
                  <v-toolbar-title>Enregistrez votre Daily Breads</v-toolbar-title>
               </v-toolbar>
               <v-form class="border-info" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" v-model="model.form">
                  <v-container>
                     <?php if (!empty($_POST) and isset($operation_success)): ?>
                        <v-alert type="success" prominent>
                           Daily Bread Enregistré avec success
                        </v-alert>
                     <?php endif ?>
                     <div>
                        <v-text-field dense label="Nom Du Daily Bread" filled name="nom" v-model="model.nom"
                        :rules="rules.nom"></v-text-field>
                     </div>
                     <div>
                        <v-text-field dense label="Titre Du Daily Bread" filled name="titre" v-model="model.titre" :rules="rules.titre"></v-text-field>
                     </div>
                     <div>
                        <v-textarea dense label="Description" filled name="description" v-model="model.description" :rules="rules.description"></v-textarea>
                     </div>
                     <div>
                        <v-file-input dense filled label="L'image Du Daily Bread"
                           prepend-inner-icon="mdi-camera" prepend-icon="" chips show-size counter accept="image/*" name="img" :rules="rules.img">
                        </v-file-input>
                     </div>
                     <br>
                     <div>
                        <v-btn type="reset" color="error">Reset</v-btn>
                        <v-btn type="submit" class="float-right" color="success" :disabled="!model.form">Enregistrer</v-btn>
                     </div>
                  </v-container>
               </v-form>
            </v-card>
      </v-container>
   </v-main>
</v-app>
</div>




<!-- j'inclut mon navigation bootom -->
<?php  require TEMPLATE_ROOT."template.bottom.php"?>
<!-- mon fichier js -->
<script src="js/create.vuetify.js" defer=""></script>