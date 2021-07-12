
<v-container>
   <!-- l'lement que va utiliser mon tinytypewritter -->
   <h1 id="appName" class="text-center"></h1>
   <v-divider></v-divider>
   <br>
   <!-- je creer les row qui vont respresenter mes videos -->
   <v-container>
      <h1 class="text-center error--text">Nous Sommes Le:</h1>
      <v-row>
         <v-col cols="12" md="12" sm="12" lg="12" xl="12" elevation="2">
            <v-card elevation="5">
               <v-date-picker full-width v-model="picker"></v-date-picker>
            </v-card>
         </v-col>

      </v-row>
   </v-container>
   <!-- je cree la row pour mes daily breads -->
   <v-container>
      <h1 class="text-center"> Les Photos</h1>
    </v-container>
   <!-- je cree la row pour mes photos -->
   <v-container>
      <h1 class="text-center"> Les News</h1>
      <v-card>
         <v-row>
            <?php  $res = $table_dailybreads->find(); ?>
            <?php if (!empty($res)): ?>
               <?php foreach ($res as $key=>$value): ?>
               <v-col cols="12" md="4" height="35vh">
               <v-card link >
                  <v-toolbar>
                     <v-toolbar-title>le <?= $value['create_at']?></v-toolbar-title>
                  </v-toolbar>
                  <v-img src="img/dailyBreads/<?= $value['path'].".".$value['extension']?>"contain
                     height="35vh" class="grey darken-4" >
                     <template v-slot:placeholder>
                        <v-row class="fill-height ma-0" align="center" justify="center">
                           <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                        </v-row>
                     </template>
                  </v-img>
                  <v-card-title class="text-h6">
                        <?=$value['titre']?>
                  </v-card-title>
               </v-card>
               </v-col>
               <?php endforeach ?>
            <?php else: ?>
               <h1> Aucun Daily Bread</h1>
            <?php  endif; ?>

         </v-row>
      </v-card>
   </v-container>

</v-container>