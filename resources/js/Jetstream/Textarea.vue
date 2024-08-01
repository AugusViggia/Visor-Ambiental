<template>
  <textarea
    :rows="rows ? rows : defaultRows"
    class="form-control"
    :class="{ 'is-invalid': error ? true : false }"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="input"
  ></textarea>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  props: {
    modelValue: String,
    error: String,
    rows: Number,
  },

  emits: ['update:modelValue'],

  data: function () {
    return {
      defaultRows: 3,
    }
  },

  methods: {
    focus () {
      this.$refs.input.focus()
    },
  },
})
</script>
