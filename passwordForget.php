<?php

    if(!isset($_SESSION)) session_start();

    if(!isset($_SESSION['step'])) $_SESSION['step'] = 1;
    require_once 'class/Autoload.php';
    Autoload::register();
    $app = App::getInstance();
    $table = Table::getInstance();
    $table_users = $table->get('users');
    $table_profil = $table->get('profil');
    $id = $table_users->getId();
    $nom = $table_users->getNom($id);
    $validator = new Validator();
    $stepper_value = 1;
    if(!empty($_POST)){
        if(isset($_POST['step1'])){
            //TODO
           $email = $_POST['email'];
           $validator->validateEmail($email);
           if(!$validator->hasError()){
              if(!$table_users->exist($email)){
               $validator->addError("Cette utilisateur ne possede pas de compte");
              }else{
                  $_SESSION['step'] = 2;
                  $_SESSION['email'] = $email;
                  $token = $table_users->getToken();
                  #je met a jour le token de l'utilisateur
                 $res = $table_users->update(['reset_password'=>$token],"where email = '".$_SESSION['email']."'");
                 if(!$res){
                     $validator->addError("Erreur lors de l'envoi du code chez l'utilisateur");
                 }
              }
           }
        }
        elseif (isset($_POST['resend']) or isset($_POST['step2'])){
           $email = $_SESSION['email'];
            if(isset($_POST['resend'])){
                $token = $table_users->getToken();

                $res = $table_users->update(['reset_password'=>$token],"where email = '$email' ");
                if(!$res){
                    $validator->addError("Erreur lors du renvoi du code");
                }else{
                    $operation_success = true;
                    $msg = "un code de validation à été renvoye avec success";
                }
            }else{
                $validator->validateNom($_POST['token']);
                if(!$validator->hasError()){
                    $token = $table_users->select("reset_password","where email = '$email'");
                    if(empty($token)){
                        $validator->addError("erreur lors de la receptio du code");
                    }else{
                        #je recupere son token
                        $code = $_POST['token'];
                        #je verifie avec le token que j'ai recu en parametre
                       if($code!=$token['reset_password']){
                           $validator->addError('Le code envoyé ne correspond pas ');
                       }else{
                           #je valide son compte et je lui permmet de passez au niveau suppereiru
                          $_SESSION['step'] = 3;
                       }
                    }

                }
            }
        }
        elseif (isset($_POST['step3'])){
            //TODO
           $password = $_POST['password'];
           $confirmPassword = $_POST['confirmPassword'];
           $validator->validatePassword($password,$confirmPassword);
           $validator->validateNom($password);
           $validator->validateNom($confirmPassword);
           if(!$validator->hasError()){
               //TODO
              $email = $_SESSION['email'];
              $res = $table_users->update(['password'=>$password],"where email = '$email' ");
              if(!$res){
                  $validator->addError("Erreur Lors de L'insertion de L'utilisateur");
                 unset($_SESSION['email']);
                 unset($_POST);
                 unset($_SESSION['step']);
              }else{
                  //je redirige l'utilisateur vers sa page de connexion
                 unset($_SESSION['email']);
                 unset($_POST);
                 unset($_SESSION['step']);
                 $operation_success = true;
                 $msg="votre mot de passe à été rédefinie avec success  <h2 class='font-weight-bold red--text text-center'>vous alez etre redirigé dans 5s</h2> <script>setTimeout(()=>{window.location.assign('connexion.php')},5000)</script>";

              }
           }
        }
    }
    $stepper_value = isset($_SESSION['step'])?$_SESSION['step']:1;
?>

<?php require_once 'includes/template.head.php'?>
<div id="app" >
    <v-app >
        <v-app-bar app short color="blue">
            <v-btn icon href="<?=$app->previousPage()?>">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-app-bar-title>Password Forget</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon href="index.php">
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-divider vertical></v-divider>
            <v-btn icon href="inscription.php" color="red">
                <v-icon>mdi-account-plus</v-icon>
            </v-btn>
        </v-app-bar>
        <v-main app>
            <v-container class="">
                <v-breadcrumbs :items="breadcrumbs.items">
                    <template #divider>
                        <v-icon>mdi-forward</v-icon>
                    </template>

                </v-breadcrumbs>
                <h1 class="text-center">Bienvenue Cher Utilisateur</h1>
                <!-- j'affiche mes erreur ici -->
               <?php if($validator->hasError()): ?>
                    <v-alert type="error" prominent>
                        <ol>
                           <?php foreach($validator->getErrors() as $key => $value):?>
                            <li><?=$value?></li>
                           <?php endforeach;?>
                        </ol>
                    </v-alert>
               <?php endif; ?>
               <?php if(isset($operation_success) and isset($msg)): ?>
                   <v-alert type="success" prominent>
                      <?=$msg?>
                   </v-alert>
               <?php endif; ?>
                <!-- fin de l'affichage de mes erreurs-->
                <v-card class="mt-4" elevation="10">
                    <v-toolbar color="blue" class="#444 lighten-2">
                        <v-toolbar-title>Mot de passe oublié?</v-toolbar-title>
                    </v-toolbar>
                    <v-stepper vertical :value="<?= $stepper_value ?>">
                        <v-stepper-step step="1" :complete="<?=$stepper_value>1?'true':'false'?>">Identification par Email</v-stepper-step>
                        <v-stepper-content step="1">
                            <v-card>
                                <v-form v-model="model.form" class="px-5 py-5" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
                                    <div>
                                        <v-text-field :rules="rules.email" name="email" label="Votre Adresse Mail" type="email" filled outlined dense counter persistent-hint hint="tapez l'adresse e-mail utilisé pour cree votre compte chez light"></v-text-field>
                                    </div>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="success" type="submit" small class="float-right" name="step1" :disabled="!model.form">
                                        Continuer
                                        <v-icon right>mdi-page-next</v-icon>
                                    </v-btn>
                                </v-card-actions>
                                </v-form>
                            </v-card>
                        </v-stepper-content>
                        <v-stepper-step step="2" :complete="<?=$stepper_value>2?'true':'false'?>">Confirmation</v-stepper-step>
                        <v-stepper-content step="2">
                            <v-card>
                                <v-form v-model="model.form" class="px-5 py-5" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
                                    <div>
                                        <v-text-field :rules="rules.token"  name="token" label="Code de Confirmation"  filled outlined dense max-counteur="4" counter persistent-hint hint="entrez le code envoyez par mail" maxlength="4">
                                            <template #append>
                                                <v-btn text flat small tile class="text-lowercase" color="blue" type="submit" name="resend">
                                                    renvoyer
                                                </v-btn>
                                            </template>
                                        </v-text-field>
                                    </div>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="success" type="submit" small class="float-right" name="step2" :disabled="!model.form2">
                                            Continuer
                                            <v-icon right>mdi-page-next</v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </v-form>
                            </v-card>
                        </v-stepper-content>
                        <v-stepper-step step="3">Renouvellement du mot de passe</v-stepper-step>
                        <v-stepper-content step="3">
                            <v-card>
                                <v-form v-model="model.form3" class="px-5 py-5" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
                                    <div>
                                        <v-text-field :rules="rules.password" name="password" label="Votre Mot de Passe" type="password" filled outlined dense counter persistent-hint hint="votre mot de passe "></v-text-field>
                                    </div>
                                    <div>
                                        <v-text-field :rules="rules.password" name="confirmPassword" label="Confirmer Votre Mot de Passe" type="password" filled outlined dense counter persistent-hint hint="confirmer votre mot de passe"></v-text-field>
                                    </div>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="primary" type="submit" small class="float-right" name="step3" :disabled="!model.form3">
                                            Finaliser
                                            <v-icon right>mdi-send</v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </v-form>
                            </v-card>
                        </v-stepper-content>
                    </v-stepper>
                </v-card>
            </v-container>
        </v-main>
        <v-footer app color="blue" class="lighten-2" dense short>
                <v-col cols="12" class="text-center text-subtitle-1 font-weight-bold">
                    Living Intimacy with God and a Holy Tranfiguration
                </v-col>
        </v-footer>
    </v-app>
</div>



<?php require_once 'includes/template.bottom.php'?>

<script src="js/passwordForget.vuetify.js" defer></script>
