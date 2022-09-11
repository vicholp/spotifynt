<template>
  <div
    class="flex flex-col gap-3"
  >
    <div class="col-span-12 flex flex-col gap-3">
      <div
        name="fade"
        class="grid grid-cols-12 gap-3"
      >
        <div
          class="rounded aspect-square w-full col-span-6 md:col-span-4 lg:col-span-3 xl:col-span-2 shadow dark:shadow-none"
        >
          <div
            class="h-full w-full bg-white bg-opacity-10 rounded dark:text-white text-black text-opacity-60 flex items-center justify-evenly font-medium flex-col"
          >
            <span class="iconify-inline text-4xl" data-icon="mdi:shuffle" />
            random album
          </div>
        </div>

        <album
          v-for="album in albums"
          :key="album.id"
          :album="album"
        />
      </div>
      <button
        type="button"
        class="bg-white text-black dark:bg-white dark:bg-opacity-5 p-3 rounded dark:text-white text-opacity-60 text-sm text-center w-full"
        @click="loadRecommendations()"
      >
        load new recommendations
      </button>
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
  async created() {
    await this.loadRecommendations();
  },
  methods: {
    async loadRecommendations() {
      const recommendations = (await RecommendationApi.random(1)).data;
      this.artists = recommendations.artists;
      this.albums = recommendations.albums;
      this.tracks = recommendations.tracks;
    },
  },
};
</script>
