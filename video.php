<?php require 'includes/template.head.php' ?>
<div id="app">
    <v-app>
        <v-app-bar app  color="blue">
            <v-btn icon>
                 <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-app-bar-title>Regarder</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon href="index.php">
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-divider vertical></v-divider>
            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
            <v-divider vertical></v-divider>
            <v-menu   transition="scale-transition" offset-y left bottom>
                <template #activator="{attrs,on}">
                    <v-btn v-bind="attrs" v-on="on" icon>
                         <v-icon >
                        mdi-dots-vertical
                    </v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item link>
                        <v-list-item-action><v-icon>mdi-cogs</v-icon></v-list-item-action>
                        <v-list-item-content><v-list-item-title>configuration</v-list-item-title><v-list-item-subtitle>confirgurez votre profil</v-list-item-subtitle></v-list-item-content>
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
                <h2 class="text-center text-capitalize">Nos Videos.=):</h2>
                <v-card height="40vh" color="error">
                    <v-card-text>
                        le premiere video
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</div>
<?php require 'includes/template.bottom.php' ?>
<script src="js/video.vuetify.js" defer=""></script>