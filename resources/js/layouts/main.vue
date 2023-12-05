<template>
  <div>
    <navbar :auth-user="authUser" />
    <slot />
    <div class="h-40" />
  </div>
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
