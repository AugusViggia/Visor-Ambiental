<template>
  <li class="nav-item">
    <Link :href="href" :class="classes">
      <slot></slot>
    </Link>
  </li>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
  components: {
    // eslint-disable-next-line vue/no-reserved-component-names
    Link,
  },

  props: ['href', 'active'],

  computed: {
    classes () {
      return this.active
        ? 'nav-link active font-weight-bolder'
        : 'nav-link'
    },
  },
})
</script>
