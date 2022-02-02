<template>
  <div
    :class="`fixed bottom-0 w-full h-20`"
    :style="{
      'background-color': `${color ? color : 'white'}`,
    }"
  >
    <div
      :class="`bg-white ${color === false ? 'bg-opacity-100' : 'bg-opacity-50'}`"
    >
      <div class="h-0.5 w-full bg-black bg-opacity-10">
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
          <div
            class="flex gap-3 items-center grow py-3"
            @click="$emit('go-full')"
          >
            <div class="">
              <div
                v-if="loaded"
                :style="{'background-image':`url(${getArtFromAlbum(this.actual.album.beetsId)})`}"
                class="h-14 bg-cover rounded shadow aspect-square"
              />
              <div
                v-else
                class="h-14 bg-cover rounded shadow aspect-square bg-gray-300"
              />
            </div>
            <div class="">
              <div
                v-if="loaded"
                class="text-medium flex-none"
              >
                {{ actual.name }} - {{ actual.artist.name }}
              </div>
              <div
                v-else
                class=""
              >
                The playlist is empty
              </div>
            </div>
          </div>
          <div :class="`ml-auto flex items-center mr-10 ${loaded ? 'opacity-100' : 'opacity-30'}`">
            <button
              class="text-4xl"
              @click="$emit('previus-track')"
            >
              <span
                class="iconify"
                data-icon="ic:round-navigate-before"
              />
            </button>
            <button
              class="text-4xl"
              @click="$emit('play-pause')"
            >
              <div v-if="status.playing">
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
              @click="$emit('next-track')"
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
import { mapState } from 'vuex';

import getArtFromAlbum from '../../../helpers/getArtFromAlbum.js';

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
  },
  computed: {
    ...mapState({
      status: state => state.player.status,
      color: state => state.player.color,
    }),
  },
  methods: {
    getArtFromAlbum,
  },
};
</script>
