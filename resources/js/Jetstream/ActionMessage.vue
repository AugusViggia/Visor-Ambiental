<template>
  <div>
    <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-show="on" class="alert alert-success" :class="customClass" role="alert">
        <div class="alert-body">
          <slot />
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  props: {
    on: {
      type: Boolean,
      default: false,
    },
    customClass: {
      type: String,
      default: 'text-white',
    },
  },
})
</script>
