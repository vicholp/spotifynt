<template>
  <div

    class="bg-white dark:bg-opacity-10 p-3 rounded flex flex-col gap-3"
  >
    <div class="col-span-12 ">
      <div
        name="fade"
        class="grid grid-cols-12 gap-3"
      >
        <album
          v-for="album in albums"
          :key="album.id"
          :album="album"
        />
      </div>
    </div>
  </div>
</template>
<script>
import RecommendationApi from '../../api/recommendation';
import Album from '../album';

export default {
  components: {
    Album,
  },
  data() {
    return {
      artists: [],
      albums: [],
      tracks: [],
    };
  },
  async mounted() {
    const recommendations = (await RecommendationApi.random(1)).data;
    this.artists = recommendations.artists;
    this.albums = recommendations.albums;
    this.tracks = recommendations.tracks;
  },
};
</script>
