<v-navigation-drawer app v-model="showSideBar" color="blue" >
    <v-btn nav icon class="float-right" @click="showSideBar=!showSideBar">
        <v-icon>mdi-arrow-left</v-icon>
    </v-btn>
  <template #append>
    <div class="px-1">

        <v-btn  block  @click="showSideBar=!showSideBar"  text color="green darken-2">
        connecté
        <v-icon right>
          mdi-check-circle
        </v-icon>
      </v-btn>

        <v-btn  block x-small  @click="showSideBar=!showSideBar" text color="red">
         <span class="text-button">déconnecté</span>
        <v-icon right>
          mdi-close
        </v-icon>
      </v-btn>
    </div>
  </template>

  <v-list>
  <v-list-item>
    <v-list-item-content>
      <v-list-item-title class="text-h4  font-weight-bold yellow--text">
        L.I.G.H.T
      </v-list-item-title>
      <br>
      <v-list-item-subtitle class="#444 white--text font-italic">
        Transforming Lives
      </v-list-item-subtitle>
    </v-list-item-content>
  </v-list-item>

  <v-divider></v-divider>
    <v-subheader>profil</v-subheader>
    <v-divider></v-divider>
    <v-list-item link class="mb-5" href="user.php">
      <v-list-item-avatar>
        <v-img src="<?=w?>" placeholder="chargement.."
          origin="center center"></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>

            </v-list-item-title>
            <v-list-item-subtitle>

            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-divider></v-divider>
      <v-list
      dense
      class="font-weight-bold"
      >
      <v-subheader >onglets</v-subheader>
      <v-divider></v-divider>
      <v-list-item-group v-model="sbmodel" color="red">
      <v-list-item link href="test.php">
        <v-list-item-icon>
          <v-icon color="#FEf">mdi-home</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Home</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

        <v-list-item link>
          <v-list-item-icon ><v-icon color="#Fef">mdi-cogs</v-icon></v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Administrateur</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item
        v-for="item in items"
        :key="item.title"
        :href="item.href" link
        >

        <v-list-item-icon>
          <v-icon color="#FEf">{{ item.icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-item-group>

  </v-list>
</v-navigation-drawer>
