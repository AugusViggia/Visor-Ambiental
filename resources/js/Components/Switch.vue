<template>
  <div class="form-check form-switch">
    <input
      :id="id"
      class="form-check-input"
      :class="$attrs.class"
      type="checkbox"
      :name="name"
      :value="value"
      v-model="proxyChecked"
    />
    <label :class="labelClass" :for="id">
      <slot />
    </label>
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  emits: ['update:checked'],

  props: {
    checked: {
      type: [Array, Boolean],
      default: false,
    },
    id: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      default: '',
    },
    labelClass: {
      type: String,
      default: '',
    },
    value: {
      default: null,
    },
  },

  computed: {
    proxyChecked: {
      get () {
        return this.checked
      },

      set (val) {
        this.$emit('update:checked', val)
      },
    },
  },
})
</script>
