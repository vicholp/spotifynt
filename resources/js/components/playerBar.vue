<template>
  <div
    :class="`fixed bottom-0 w-full bg-[#EFEFEF] dark:bg-[#101010]`"
  >
    <div class="bg-white dark:bg-opacity-5 p-2" hidden />
    <div
      :class="`bg-white ${color === false ? 'bg-opacity-100' : 'bg-opacity-5'}`"
    >
      <div class="h-0.5 w-full bg-black bg-opacity-5">
        <div
          class="h-full bg-black bg-opacity-50"
          :style="{
            'width': `${progress}%`,
          }"
        />
      </div>
      <div class="container mx-auto my-auto px-3">
        <div
          class="flex gap-3 items-center"
        >
          <router-link
            class="flex gap-3 items-center grow py-3"
            to="/player"
          >
            <div class="">
              <div
                v-if="loaded"
                :style="`background-image: url(&quot;${actual.release.art[75]}&quot;);`"
                class="h-14 bg-cover rounded shadow aspect-square"
              />
              <div
                v-else
                class="h-14 bg-cover rounded shadow aspect-square dark:bg-white dark:bg-opacity-5"
              />
            </div>
            <div class="">
              <div
                v-if="loaded"
                class="text-medium flex-none"
              >
                {{ actual.title }} - {{ actual.release.title }}
              </div>
              <div
                v-else
                class="dark:text-white dark:text-opacity-30"
              >
                The playlist is empty
              </div>
            </div>
          </router-link>
          <div :class="`flex items-end ${loaded ? 'opacity-100' : 'opacity-30'}`">
            <button
              class="text-4xl"
              @click="$emit('player-prev')"
            >
              <span
                class="iconify"
                data-icon="ic:round-navigate-before"
              />
            </button>
            <button
              class="text-4xl"
              @click="$emit('player-play')"
            >
              <div v-if="playing">
                <span
                  class="iconify"
                  data-icon="ic:round-pause"
                />
              </div>
              <div v-else>
                <span
                  class="iconify"
                  data-icon="ic:round-play-arrow"
                />
              </div>
            </button>
            <button
              class="text-4xl"
              @click="$emit('player-next')"
            >
              <span
                class="iconify"
                data-icon="ic:round-navigate-next"
              />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import PlayerStore from '../store/player';


export default {
  props: {
    progress: {
      type: Number,
      required: true,
    },
    actual: {
      type: Object,
      required: true,
    },
    loaded: {
      type: Boolean,
      required: true,
    },
    playing: {
      type: Boolean,
      required: true,
    },

  },
  emits: [
    'player-next',
    'player-prev',
    'player-play',
  ],
  setup() {
    return {
      playerStore: PlayerStore(),
    };
  },
  data() {
    return {
      n: 0,
    };
  },
  computed: {
    color() {
      return 'a';
    },
  },
};
</script>
