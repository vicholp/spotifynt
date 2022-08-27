<template>
  <nav
    class="p-6"
  >
    <div class="flex">
      <router-link to="/" class="text-opacity-90">
        spotifynt
      </router-link>
      <div class="ml-auto" />
      <div />
    </div>
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
