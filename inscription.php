<!-- code php qui vas le backend -->
<?php

#je demare une session si elle n'existe pas
if (!isset($_SESSION)) session_start();

# j'inclut et j'active mon autoloader
require 'class/Autoload.php';
Autoload::register();
#je je me met sur le premier ste
if (!isset($_SESSION['stepperStep'])) $_SESSION['stepperStep'] = 1;
#je cree mon validateur
$validator = new Validator();
#je verifie si on a poster les donnes
$table_user = Table::getInstance()->get("users");
$table_profil = Table::getInstance()->get('profil');
$app = App::getInstance();
if (!empty($_POST)) {
   #je me met dans e cas ou on est sur le premier step
   if (isset($_POST['inscrire']) and $_SESSION['stepperStep'] == 1) {
      #je me creer un nouveau validateur
      # je verifie mes donnes recuperer en post dans le premier stepper
      $validator->validateEmail($_POST['Email']);
      $validator->validateTel($_POST['Phone']);
      $validator->validateNom($_POST['Username']);
      $validator->validateNom($_POST['Country']);
      $validator->validateNom($_POST['City']);
      $validator->validateAge($_POST['Birthday']);
      $validator->ValidatePassword($_POST['Password'], $_POST['ConfirmPassword']);
      $validator->ValidateImg($_FILES['profil']);
      #je verifie si l'utilisateur n'existe pas déja dans la bd
      if ($table_user->select("email", "where email = '{$_POST["Email"]}' "))
         $validator->addError("Cette adresse mail à déja été utilisé pour un autre compte");

      #si il n'ya aucune erreur
      if (!$validator->hasError()) {
         # j'insere mon utilisateur dans la base de donnee
         $table_user->insert(['nom' => $_POST['Username'], 'email' => $_POST['Email'], 'tel' => $_POST['Phone'], 'age' => $_POST['Birthday'], 'password' => $_POST['Password'], 'pays' => $_POST['Country'], 'ville' => $_POST['City'], 'sexe' => $_POST['Gender'], 'active' => 0, 'create_at' => 'NOW()', 'token' => $table_user->getToken()]);

         $_SESSION['auth'] = $_POST['Email'];
         $id_user = $table_user->getId();
         $profil_name = App::getInstance()->generateFileName($_POST['Username']);
         $extension = pathinfo($_FILES['profil']['name'])['extension'];
         $file_name = $profil_name . "." . $extension;
         #je recupere mon utilisateur qui à l'id
         //$id_user = Database::getInstance()->getIdByEmail($_POST['Email']);
         $table_profil->insert(['nom' => $profil_name, 'extension' => $extension,
            'create_at' => 'NOW()', 'update_at' => 'NOW()', 'id_user' => $id_user]);

         $app->uploadFile($_FILES['profil']['tmp_name'], $file_name, "profil");


         #je passe au stepper suivant
         $_SESSION['stepperStep'] = 2;
      }
   }
   #si nous sommes au dexuieme stepper
   if ((isset($_POST['valider']) or isset($_POST['coderesend'])) and $_SESSION['stepperStep'] == 2) {
      if (isset($_POST['coderesend'])) {
         #je genere un nouveau token
         $token = $table_user->getToken();
         #je change l'ancien token par le nouveau regenre
         $table_user->updateToken($table_user->getId());
      } else {
         #je recupere le token enregistrez dans la bd
         $db_token = $table_user->select('token', "where id = " . $table_user->getId());
         #je compare avec celle recu dans les donnes posté et je fait le traitement
         if ($db_token['token'] == $_POST['code']) {
            #j'active le compte de l'utilisateur
            $id_user = $table_user->getId();
            $table_user->update(['active' => 1, 'activate_at' => 'NOW()', 'token' => 'null'], "where id = $id_user");
            #je passe sur le stepper suivant
            $_SESSION['stepperStep'] = 3;
         } else {
            $codeValid = false;
         }
      }
   }

}

?>
<!-- fin du traitement -->

<!-- j'inclut tout le haut de mon application -->
<?php require 'includes/template.head.php' ?>

<!-- partie main de ma page -->
<div id="app">
    <v-app>
        <v-app-bar app color="blue" short elevation="15">
            <v-btn icon href="<?=$app->previousPage()?>">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-app-bar-title>Inscription</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn text href="index.php" small>
                <v-icon icon>mdi-home</v-icon>
            </v-btn>
            <v-divider vertical></v-divider>
            <v-btn text dense href="connexion.php" small>
                <v-icon left>mdi-account-arrow-left</v-icon>
                Connexion
            </v-btn>
        </v-app-bar>
        <v-main app>
            <v-breadcrumbs :items="items">
                <template #divider>
                    <v-icon>mdi-forward</v-icon>
                </template>
                <template #item={item}>
                    <v-breadcrumbs-item :disabled="item.disabled" :href="item.href">
                        {{ item.text }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
            <v-container>
                <h2 class="text-center text-capitalize">Creation de Votre Compte</h2>
                <!-- j'affiche mes erreur ici si disponible  -->
               <?php if ($validator->hasError()): ?>
                   <v-alert type="error" dense
                            prominent dismissible border="bottom" transition="fade-transition" outlined>
                       Des Erreurs ont été rencontré sur les données envoyer
                   </v-alert>
                   <v-dialog max-width="400" :value="<?php echo "dialog"; ?>" permanent>
                       <h2 class="text-center yellow">Les erreur rencontres</h2>
                       <template #activator="{attrs,on}">
                           <h1 class="text-center">
                               <v-btn v-bind="attrs" v-on="on" class="text-center"
                                      color="success" @click.stop="<?php echo "dialog=true"; ?>">
                                   voir les erreurs.
                               </v-btn>
                           </h1>
                       </template>
                       <v-divider></v-divider>
                       <v-list>
                          <?php foreach ($validator->getErrors() as $key => $value): ?>
                              <v-list-item>
                                  <v-list-item-action><?= ++$key ?></v-list-item-action>
                                  <v-list-item-content><?= $value ?></v-list-item-content>
                              </v-list-item>
                          <?php endforeach ?>
                       </v-list>
                       <v-btn class="float-right" color="error" @click.stop=" dialog = false">
                           Fermer
                           <v-icon right>mdi-delete</v-icon>
                       </v-btn>
                   </v-dialog>
                   <br>
               <?php endif ?>
                <!-- fin de l'affichage des erreurs-->
                <v-card>
                    <v-stepper :value="<?= $_SESSION['stepperStep'] ?>">
                        <v-stepper-header>
                            <v-stepper-step
                                step="1" <?php echo $validator->hasError() ? ":rules='[()=>{return false}]'" : ":complete='true'"; ?> >
                                Creation
                            </v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step step="2" <?php if ($_SESSION['stepperStep'] > 2) echo ":complete='true'" ?>>
                                Validation
                            </v-stepper-step>
                            <v-divider></v-divider>
                            <v-stepper-step step="3">Connecter Vous</v-stepper-step>
                        </v-stepper-header>
                        <v-stepper-items>
                            <v-stepper-content step="1">
                                <v-form dense v-model="validForm" class="lighten-9  py-5" method="post"
                                        action="<?= $_SERVER['PHP_SELF'] ?>" ref="form" enctype="multipart/form-data">

                                    <v-text-field dense size="sm" filled label="Nom" append-icon="mdi-account" required
                                                  name="Username" :rules="rules.nom">
                                    </v-text-field>

                                    <v-text-field size="sm" dense filled label="Email" name="Email"
                                                  append-icon="mdi-email" required type="email"
                                                  :rules="rules.email"></v-text-field>

                                    <v-text-field :type="passwordVisible? 'text':'password'" dense name="Password"
                                                  filled label="Mot de Passe"
                                                  :append-icon=" passwordVisible?'mdi-eye':'mdi-eye-off' "
                                                  @click:append=" passwordVisible = !passwordVisible"
                                                  :rules="passwordRules" v-model="passwordModel">
                                    </v-text-field>
                                    {{ passwordModel==confirmPasswordModel }}
                                    <v-text-field :type="confirmPasswordVisible? 'text':'password'" dense
                                                  name="ConfirmPassword" filled label="Confirmer le Mot de Passe"
                                                  :append-icon=" confirmPasswordVisible ? 'mdi-eye':'mdi-eye-off'  "
                                                  @click:append=" confirmPasswordVisible = !confirmPasswordVisible "
                                                  :rules="confirmPasswordRules"
                                                  v-model="confirmPasswordModel"></v-text-field>

                                    <v-text-field name="Birthday" filled :value="values.age" dense label="Age" required>
                                        <template #prepend-inner>
                                            <v-btn color="red" x-small @click="values.age?values.age-- : 0">
                                                <v-icon>mdi-minus</v-icon>
                                            </v-btn>
                                        </template>
                                        <template #append>
                                            <v-btn x-small color="success" @click="values.age<100?values.age++ : 0">
                                                <v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                        </template>
                                    </v-text-field>

                                    <v-select label="Genre" name="Gender" :items="['Homme','Femme']" :value="'Homme'"
                                              filled dense append-icon="mdi-human"></v-select>

                                    <v-select filled label="Ville" name="City" dense v-model="ville"
                                              :items="villes" append-icon="mdi-city"></v-select>

                                    <v-select label="Votre Pays" filled :items="pays" dense v-model="pay"
                                              name="Country"></v-select>

                                    <v-text-field name="Phone" filled type="number"
                                                  :prefix="(codes[pay])?' +'+codes[pay]:'+ ...'" dense
                                                  append-icon="mdi-phone" required></v-text-field>

                                    <v-file-input accept="image/*" chips counter show-size name="profil" ref="img"
                                                  label="Votre Photo de Profile" prepend-icon=""
                                                  prepend-inner-icon="mdi-camera" dense filled truncate-length="50"
                                                  :rules="rules.file" append-icon="mdi-account">
                                    </v-file-input>

                                    <!-- les boutons pour la soumissin du formulaire -->
                                    <v-btn type="reset" color="error" class="p-4 text-sm-subtitle-2"
                                           @click="$refs.form.reset();resetLoader=true;$refs.form.resetValidation()"
                                           :loading="resetLoading">
                                        Reinitialiser
                                        <v-icon right>mdi-delete</v-icon>
                                    </v-btn>

                                    <v-btn :disabled="!validForm" class="float-right" :disable="loading"
                                           color="success" class="p-4" :loading="loading" type="submit"
                                           @click="loader ='creer' " name="inscrire">
                                        Creer
                                        <v-icon right>mdi-account-plus</v-icon>
                                        <template #loader>
                                            Traitement..
                                        </template>
                                    </v-btn>
                                </v-form>
                            </v-stepper-content>

                            <v-stepper-content step="2">
                                <!-- j'affiche l'alerte si les donnes n'ont pas encore ete posté -->
                               <?php if ($_SESSION['stepperStep'] == 2 and !isset($_POST['valider']) and !isset($_POST['coderesend'])): ?>
                                   <v-alert type="success" prominent  transition='scale-transition'>
                                       Un code de Vérification à  été envoye a
                                       <em><a href="#" class="alert-link"><?= $_SESSION['auth'] ?></a></em>
                                   </v-alert>
                               <?php endif ?>

                                <!-- l'alerte qui sera affiché si l'utilisateur redemande un code d'activation -->
                               <?php if ($_SESSION['stepperStep'] == 2 and (isset($_POST['coderesend']))): ?>
                                   <v-alert type="success"  transition='scale-transition'
                                            class="text-subtitle-2">
                                       Un code de Vérification à été réenvoyer
                                       <em><a href="#" class="alert-link"><?= $_SESSION['auth'] ?></a></em>
                                   </v-alert>
                               <?php endif ?>

                               <?php if (isset($codeValid)): ?>
                                   <v-alert type="error" prominent  transition='scale-transition'>
                                       Code Incorect
                                   </v-alert>
                               <?php endif ?>
                                <v-form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                                    <v-text-field label="Le code de Validation" hint="saisir le code à 4 chiffre reçu" filled append-icon="mdi-mail" maxlength="4"  :counter="4" name="code">
                                    </v-text-field>
                                    <v-row>
                                        <v-col>
                                            <v-btn color="info" name="coderesend" type="submit">
                                                renvoyer le code
                                                <v-icon>mdi-share</v-icon>
                                            </v-btn>
                                        </v-col>
                                        <v-col>
                                            <v-btn class="float-right" type="submit" color="success" name="valider">
                                                Valider
                                                <v-icon right>mdi-send</v-icon>
                                            </v-btn>

                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-stepper-content>

                            <v-stepper-content step="3">

                                <h2 class="text-center">
                                    Bravo !!! Vous avez maintenant créér votre Compte Avec Success
                                </h2>
                                <div class="text-center">
                                    <v-btn link href="index.php" color="success">Commencer</v-btn>
                                </div>
                            </v-stepper-content>
                        </v-stepper-items>
                    </v-stepper>
                </v-card>
            </v-container>
        </v-main>
        <v-footer app color="blue" short>
            <v-container class="white--text">
                <v-row><v-col cols="12" class="text-center text-subtitle-2 font-weight-bold">
                        Living Intimacy With God And A Holy Tranfiguration
                    </v-col></v-row>
            </v-container>
        </v-footer>
    </v-app>
</div>
<?php require 'includes/template.bottom.php' ?>
<script src="js/inscription.vuetify.js" defer=""></script>






