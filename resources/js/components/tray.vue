<template>
  <div
    class="absolute w-full hidden"
  >
    <div
      :class="`fixed top-0 w-full bg-white dark:bg-black
        transition-all duration-300 ease-in
        ${messagesStore.show ? 'bg-opacity-100' : 'bg-opacity-0 '}`"
    >
      <div
        :class="`p-3 text-center text-xs dark:bg-white  dark:text-white
          transition-all duration-300 ease-in
          ${messagesStore.show ? 'dark:bg-opacity-10 dark:text-opacity-60' : 'dark:bg-opacity-0 dark:text-opacity-0'}`"
      >
        {{ messagesStore.message }}
      </div>
    </div>
  </div>
</template>
<script>

import MessagesStore from '../store/messages';

export default {
  setup() {
    const messagesStore = MessagesStore();

    return { messagesStore };
  },
  data() {
    return {
      timer: null,
    };
  },
};
</script>
