import { createApp } from 'vue';
// eslint-disable-next-line no-unused-vars
import Iconify from '@iconify/iconify';

import { createRouter, createWebHashHistory } from 'vue-router';

import { camelizeKeys } from 'humps';

import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

import i18n from './locales';
import pinia from './store';

import Index from './pages/index.vue';
import Server from './pages/servers.vue';

const app = createApp();

Sentry.init({
  app,
  dsn: process.env.SENTRY_DSN || null,
  environment: process.env.SENTRY_ENVIRONMENT,
  integrations: [
    new Integrations.BrowserTracing(),
  ],
  sampleRate: process.env.SENTRY_SAMPLE_RATE || false,
  tracesSampleRate: process.env.SENTRY_TRACES_SAMPLE_RATE || false,
});

const routes = [
  { path: '/', component: Index },
  { path: '/servers', component: Server, props: true },
];

const router = createRouter({
  // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
  history: createWebHashHistory('/player/'),
  routes, // short for `routes: routes`
});

app.use(i18n);
app.use(pinia);
app.use(router);

app.config.globalProperties.$filters = {
  camelizeKeys,
};

app.mount('#app');
