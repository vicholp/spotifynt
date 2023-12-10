<template>
  <layout>
    <div class="container mx-auto flex flex-col gap-5 px-2">
      <Server />
      <div class="flex bg-white dark:bg-opacity-5 px-3 py-1 items-center rounded gap-3 shadow dark:shadow-none">
        <span
          class="iconify text-lg"
          data-icon="mdi:magnify"
        />
        <input
          v-model="query"
          type="text"
          class="bg-white bg-opacity-0 w-full border-0 h-10 p-0"
          placeholder="search"
          @input="sendQuery"
        >
      </div>
      <KeepAlive>
        <IndexRecommendations v-if="query.length === 0" />
        <QueryResults
          v-else
          :results="queryResults"
        />
      </KeepAlive>
    </div>
  </layout>
</template>
<script>

import { mapState } from 'pinia';
import IndexRecommendations from '@/components/index/recommendations';
import Layout from '../layouts/main';
import QueryResults from '../components/index/queryResults.vue';
import Server from '../components/server.vue';
import ServerApi from '../api/server';
import ServerStore from '../store/server';

const WAITING_TIME_QUERY = 100; // [ms]

export default {
  components: {
    IndexRecommendations,
    Layout,
    QueryResults,
    Server,
  },
  setup() {
    const example = ServerStore();
    return { example };
  },
  data() {
    return {
      query: this.$route.query.q ?? '',
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

    if (this.query.length > 0) {
      this.sendQuery();
    }
  },
  methods: {
    // Espera WAITING_TIME_QUERY para hacer la query, y comprueba que la query no ha cambiado para hacerla.
    async sendQuery() {
      if (this.query.length === 0) {
        this.queryResults = [];
        history.pushState(null, null, 'player#/');

        return;
      }
      const initialQuery = this.query;
      setTimeout(async () => {
        const actualQuery = this.query;
        if (actualQuery !== initialQuery) return;
        const results = (await ServerApi.searchContent(this.activeServer.id, this.query)).data;
        const finalQuery = this.query;
        if (finalQuery !== initialQuery) return;
        history.pushState(null, null, `#/?q=${this.query}`);

        const queryResults = {
          'albums': results.albums,
          'artists': results.artists,
          'tracks': results.tracks.data,
        };
        this.queryResults = queryResults;
      }, WAITING_TIME_QUERY);
    },
  },
};
</script>
