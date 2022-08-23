<template>
  <Listbox v-model="selectedoption">
    <ListboxButton>{{ selectedoption.name }}</ListboxButton>
    <ListboxOptions>
      <ListboxOption
        v-for="option in options"
        :key="option"
        :value="option"
        :disabled="option.unavailable"
      >
        {{ option.name }}
      </ListboxOption>
    </ListboxOptions>
  </Listbox>
</template>

<script>
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue';

export default {
  components: {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
  },
  props: {
    options: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      selectedoption: this.options[0],
    };
  },
};
</script>
