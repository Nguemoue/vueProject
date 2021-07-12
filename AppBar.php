<v-app-bar app  color="blue" short>
  <v-app-bar-nav-icon @click="showSideBar = !showSideBar"></v-app-bar-nav-icon>
  <v-app-bar-title class="white--text font-weight-bold">L.I.G.H.T</v-app-bar-title>
  <v-spacer></v-spacer>
  <v-expand-x-transition>
    <v-form class="fill-width mt-5" v-show="searchModel===false">
      <v-text-field append-icon="mdi-magnify" dense filled  color="white"   placeholder="Video, images, etc..." size="sm" sm clearable></v-text-field>
    </v-form>
  </v-expand-x-transition>
  <div>
    <v-tooltip bottom right>
    <template #activator="{on,attrs}">
        <div v-bind="attrs" v-on="on">
          <v-btn icon v-if="searchModel==true" @click="searchModel=!searchModel" >
          <v-icon icon>
            mdi-magnify
          </v-icon>
        </v-btn>
        <v-btn icon v-else @click="searchModel=!searchModel">
          <v-icon icon>
            mdi-close
          </v-icon>
        </v-btn>
        </div>
    </template>
    <span>{{  searchModel? 'rechercher':'fermer'}}</span>
      </v-tooltip>
  </div>
</v-app-bar>