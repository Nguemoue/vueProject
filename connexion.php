<?php
    if(!isset($_SESSION)) session_start();
    require 'class/Autoload.php';
    Autoload::register();
    #je cree mon validateur
    $validator = new Validator();
    if(!empty($_POST)){
        $validator->validateEmail($_POST['Email']);
        if(!$validator->hasError()){
            $email = $_POST['Email'];
            $password = $_POST['Password'];

            $users_table = Table::getInstance()->get('users');
            #je selectionne tout les utilisateur de ma bd
            $user = $users_table->select("*","where email = '$email' and password = '$password'");
            #je verifie si l'utilisateur existe
            if(empty($user)){
                $validator->addError("Identifiant ou mot de passe incorrect");
            }else{
                $_SESSION['auth'] = $_POST['Email'];
                $operation_success = true;
            }
        }
    }
?>
<?php require 'includes/template.head.php' ?>
    <div id="app">
        <v-app>
            <v-app-bar app expand-on-scroll color="blue">
                <v-app-bar-title>Connexion</v-app-bar-title>
                <v-spacer></v-spacer>
                <v-btn text href="index.php">
                    <v-icon icon >mdi-home</v-icon>
                </v-btn>
                <v-divider vertical></v-divider>
                <v-btn text dense href="inscription.php" small>
                    <v-icon left>mdi-account-plus</v-icon>
                    Inscription
                </v-btn>
            </v-app-bar>
        <v-main>
        <v-container>
            <v-row>
                <v-breadcrumbs :items="items">
                    <template #divider>
                        <v-icon>mdi-forward</v-icon>
                    </template>
                    <template #item={item}>
                        <v-breadcrumbs-item :disabled="item.disabled" :href="item.href">{{  item.text }}</v-breadcrumbs-item>
                    </template>
                </v-breadcrumbs>
            </v-row>
            <hr><br>
            <h2 class="text-center text-capitalize text-decoration-underline">
              </i>Connecter Vous <i class="mdi mdi-account-key"></i>
            </h2>
            <v-form dense class="lighten-9 px-5 py-5" method="post" v-model="model.form" action="<?=$_SERVER['PHP_SELF']?>">
                <!-- j'affiche mon message de succes -->
                <?php if (isset($operation_success)): ?>
                    <v-alert type="success" prominent small dismissible transition="fade-transition">
                        Vous êtes maintenant connécte
                    </v-alert>
                <?php endif ?>
                <?php if ($validator->hasError()): ?>
                    <v-alert type="error" dismissible prominent transition="fade-transition">
                        <?php foreach ($validator->getErrors() as $key => $value): ?>
                            <h3 class="text-center"><?=$value?></h3>
                        <?php endforeach ?>
                    </v-alert>
                <?php endif ?>
                <br>
                    <v-text-field  dense filled label="Email" name="Email" outlined append-icon="mdi-email"  type="email" v-model="model.email"  :rules="rules.email" hint="Entrez votre adresse mail" persistent-hint></v-text-field><br>
                <v-text-field :type=" showpass? 'text':'password'" dense name="Password"  outlined filled label="Mot de Passe"  :append-icon=" showpass ? 'mdi-eye' : 'mdi-eye-off' " @click:append=" showpass = !showpass " :rules="rules.password" v-model="model.password" persistent-hint hint="entrez votre mot de passe" ></v-text-field>
                <a href="#">mot de passe oublié ?</a><br>

                <v-container>
                        <v-btn type="reset" color="error" class="p-4">
                    reset <v-icon right>mdi-delete</v-icon>
                </v-btn>
                <v-btn class="float-right" color="success" class="p-4" type="submit" :disabled="!model.form">
                    Login
                    <v-icon right>mdi-account-arrow-left</v-icon>
                </v-btn>
                </v-container>
            </v-form>
        </v-container>
    </v-main>
    <v-footer app align="center" class="text-center">
        <v-container class="text-center">copyright &copy L.I.G.H.T tout droit réservé;</v-container>
    </v-footer>
    </v-app>
    </div>
<?php require 'includes/template.bottom.php' ?>
<script src="js/connexion.vuetify.js" defer=""></script>