<?php
    require 'class/Autoload.php';
    Autoload::register();
    $databse = Database::getInstance();
    var_dump(Table::getInstance()->get($databse,'users'));
    echo "<br>";
    var_dump(Table::getInstance()->get($databse,'users'));
    var_dump(Table::getInstance()->get($databse,'users'));
    die();

 ?>

<?php require 'includes/template.head.php' ?>
<div id="app">
    <v-app>
        <v-app-bar app  color="blue">
            <v-app-bar-title>Connexion</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn text href="index.php">
                <v-icon icon left>mdi-home</v-icon>
                Home
            </v-btn>
            <v-divider vertical></v-divider>
            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
            <v-divider vertical></v-divider>
            <v-menu bottom right>
                <template #activator="{attrs,on}">
                    <v-icon navs v-bind="attrs" v-on="on">
                        mdi-dots-vertical
                    </v-icon>


                </template>
                <v-list>
                    <v-list-item link>
                        <v-list-item-action><v-icon>mdi-cog</v-icon></v-list-item-action>
                        <v-list-item-title>configuration</v-list-item-title>
                    </v-list-item>

                    <v-list-item link>
                        <v-list-item-action><v-icon>mdi-account</v-icon></v-list-item-action>
                        <v-list-item-content>connexion</v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
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
                <h2 class="text-center text-capitalize text-underline">A Propos De L.I.G.H.T </h2>

            </v-container>
        </v-main>
    </v-app>
</div>
<?php require 'includes/template.bottom.php' ?>
<script src="js/about.vuetify.js"></script>