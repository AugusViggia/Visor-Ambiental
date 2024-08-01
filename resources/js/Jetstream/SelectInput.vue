<template>

    <select
        class="form-select"
        :class="{ 'is-invalid': error }"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <slot></slot>
    </select>

</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  props: ['modelValue', 'error'],

  emits: ['update:modelValue'],

})
</script>
