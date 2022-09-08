<template>
  <nav
    class="h-20 flex items-center justify-center px-3 container mx-auto"
  >
    <router-link to="/" class="text-opacity-90 text-3xl font-[Allura]">
      spotifynt
    </router-link>
  </nav>
</template>
<script>
export default {
  props: {
    authUser: {
      default: () => {},
      type: Object,
    },
  },
};
</script>
