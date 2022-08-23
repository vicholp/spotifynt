<template>
  <layout>
    <div class="container mx-auto flex flex-col gap-5">
      <div class="bg-white dark:bg-opacity-10 p-3 rounded flex flex-col gap-3">
        <input
          v-model="query"
          type="text"
          class="rounded w-full border bg-white dark:bg-opacity-10"
          placeholder="search"
          @input="sendQuery"
        >
      </div>
      <IndexRecommendations v-if="query.length === 0" />
      <QueryResults v-else :results="queryResults" />
    </div>
  </layout>
</template>
<script>

import Layout from '../layouts/main';
import ServerApi from '../api/server';
import IndexRecommendations from '../components/index/recommendations';
import QueryResults from '../components/index/queryResults.vue';
import ServerStore from '../store/server';
import { mapState } from 'pinia';

const WAITING_TIME_QUERY = 100; // [ms]

export default {
  components: {
    IndexRecommendations,
    Layout,
    QueryResults,
  },
  setup() {
    const example = ServerStore();
    return { example };
  },
  data() {
    return {
      query: '',
      queryResults: [],
    };
  },
  computed: {
    ...mapState(ServerStore, ['activeServer']),
  },
  async mounted() {
    if (process.env.APP_ENV === 'production') {
      window.addEventListener('beforeunload', e => {
        e.preventDefault();
        e.returnValue = '';
      });
    }
  },
  methods: {
    // Espera WAITING_TIME_QUERY para hacer la query, y comprueba que la query no ha cambiado para hacerla.
    async sendQuery() {
      if (this.query.length === 0) {
        this.queryResults = [];
        return;
      }
      const initialQuery = this.query;
      setTimeout(async () => {
        const actualQuery = this.query;
        if (actualQuery !== initialQuery) return;
        const results = (await ServerApi.searchContent(this.activeServer.id, this.query)).data;
        const finalQuery = this.query;
        if (finalQuery !== initialQuery) return;
        this.queryResults.albums = results.albums;
        this.queryResults.tracks = results.tracks.data;
      }, WAITING_TIME_QUERY);
    },
  },
};
</script>
