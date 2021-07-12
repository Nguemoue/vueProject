<v-card>
  <v-card-text>
      <v-carousel hide-arrow height="90vh" :show-arrows="false" :continious="false" v-model="carousel" ref="carousel" hide-delimiter-background >
      <v-carousel-item class="red lighten-2"> page1</v-carousel-item>
      <v-carousel-item class="red lighten-9">page 2</v-carousel-item>
      <v-carousel-item>page 3</v-carousel-item>
      <v-carousel-item>page 4</v-carousel-item>
  </v-carousel>
  </v-card-text>
  <v-card-action>
      <v-btn @click="prevCarousel" v-if="carousel!=0" icon >
      <v-icon >mdi-arrow-left</v-icon>
      </v-btn>

    <v-btn @click="nextCarousel" v-if="carousel<=2" icon class="float-right">
    <v-icon right >mdi-arrow-right</v-icon>
    </v-btn>
    <a v-else icon href="index.php"  class="float-right" @click="">
      <v-icon> mdi-check</v-icon>
    </a>
  </v-card-action>
</v-card>












<!-- <h1 id="appName" class="text-center"></h1> -->
<!-- <div style="height:100%;display:flex;flex-direction: column;">
  <div style="height:94%">
      <v-carousel hide-arrow height="100%" :show-arrows="false" :continious="false" v-model="carousel" ref="carousel" hide-delimiter-background >
      <v-carousel-item class="red lighten-2"> page1</v-carousel-item>
      <v-carousel-item class="red lighten-9">page 2</v-carousel-item>
      <v-carousel-item>page 3</v-carousel-item>
      <v-carousel-item>page 4</v-carousel-item>
  </v-carousel>
  </div>
<div style="height:6%" class="primary">

      <v-btn @click="prevCarousel" v-if="carousel!=0" icon >
      <v-icon >mdi-arrow-left</v-icon>
      </v-btn>

    <v-btn @click="nextCarousel" v-if="carousel<=2" icon class="float-right">
    <v-icon right >mdi-arrow-right</v-icon>
    </v-btn>
    <a v-else icon href="index.php?start=0"  class="float-right" @click="">
      <v-icon> mdi-check</v-icon>
    </a>

</div>
</div>




 -->