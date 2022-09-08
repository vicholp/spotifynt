<template>
  <navbar :auth-user="authUser" />
  <slot />
  <div class="h-40" />
</template>
<script>
import Navbar from './navbar.vue';

export default {
  components: {
    Navbar,
  },
  props: {
    authUser: {
      default: () => {},
      type: Object,
    },
  },
};
</script>
