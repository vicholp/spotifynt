<template>
  <div style="" class="flex">
    i18n: {{ $t('example') }} <br>
    pinia: {{ example.prop }} - {{ prop }}
  </div>
</template>
<script>

import { mapState } from 'pinia';
import exampleStore from '../stores/example';

export default {
  setup() {
    const example = exampleStore();

    return { example };
  },
  computed: {
    ...mapState(exampleStore, ['prop']),
  },
};
</script>
