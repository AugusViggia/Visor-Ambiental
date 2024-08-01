<template>
  <div class="d-flex flex-column mb-2">
    <span :class="labelAppearance">
      {{ label }}
    </span>
    <span :class="[textColor, 'border-bottom']">
      {{ text || 'Sin Especificar' }}
    </span>
  </div>
</template>

<script>
export default {
  name: 'DataField',
  props: {
    label: {
      type: String,
      required: true,
    },
    text: {
      type: [String, Number],
      default: null,
    },
    textColor: {
      type: String,
      default: 'text-dark',
    },
    labelAppearance: {
      type: Array,
      default: () => ['small', 'font-italic'],
    },
  },
}
</script>
