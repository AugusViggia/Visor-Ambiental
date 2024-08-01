<template>
  <button :type="props.type" :class="`btn ${props.class}`">
    <slot></slot>
  </button>
</template>

<script setup>
const props = defineProps({
  type: {
    type: String,
    default: 'submit',
  },
  class: {
    type: String,
    default: 'btn-secondary',
  },
})
</script>
