import { createApp } from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

import { createRouter, createWebHashHistory } from 'vue-router';

import { camelizeKeys } from 'humps';

import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

import i18n from './locales';
import pinia from './store';

import AudioPlayer from './components/player.vue';
import Index from './pages/index.vue';


import ServersIndex from './pages/servers/index.vue';
import ServersCreate from './pages/servers/create.vue';
// import ServersEdit from './pages/servers/edit.vue';
import ServersShow from './pages/servers/show.vue';

import Player from './pages/player.vue';
import Artist from './pages/artist.vue';
import Album from './pages/album.vue';
import Track from './pages/track.vue';
import Playlist from './pages/playlist.vue';
import Playlists from './pages/playlists.vue';

const app = createApp();

const routes = [
  { path: '/', component: Index, props: true },

  { path: '/servers', component: ServersIndex, props: true },
  { path: '/servers/create', component: ServersCreate, props: true },
  { path: '/servers/:id', component: ServersShow, props: true },
  // { path: '/server/:id/edit', component: ServersEdit, props: true },

  { path: '/player', component: Player, props: true },
  { path: '/artist/:id', component: Artist, props: true },
  { path: '/album/:id', component: Album, props: true },
  { path: '/track/:id', component: Track, props: true },
  { path: '/playlist/:id', component: Playlist, props: true },
  { path: '/playlists', component: Playlists, props: true },
];

const router = createRouter({
  // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
  history: createWebHashHistory('/player/'),
  routes, // short for `routes: routes`
});

Sentry.init({
  app,
  dsn: process.env.SENTRY_DSN || null,
  environment: process.env.SENTRY_ENVIRONMENT,
  integrations: [
    new Integrations.BrowserTracing({
      routingInstrumentation: Sentry.vueRouterInstrumentation(router),
    }),
  ],
  sampleRate: process.env.SENTRY_SAMPLE_RATE || false,
  tracesSampleRate: process.env.SENTRY_TRACES_SAMPLE_RATE || false,
  trackComponents: true,
});

app.use(i18n);
app.use(pinia);
app.use(router);
app.use(Toast);

app.config.globalProperties.$filters = {
  camelizeKeys,
};

app.component('AudioPlayer', AudioPlayer);

app.mount('#app');
