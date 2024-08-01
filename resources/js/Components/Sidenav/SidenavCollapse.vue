<template>
  <Link
    :class="['nav-link', isActive ? 'active' : '']"
    :href="to.route || to"
    v-bind="$attrs"
    :title="navText"
  >
    <div
      :class="[
        'text-center',
        'bg-white',
        'shadow',
        'icon',
        'icon-shape',
        'icon-sm',
        'border-radius-md',
        'd-flex',
        'align-items-center',
        'justify-content-center',
        'me-2',
      ]"
    >
      <slot name="icon" v-bind:isActive="isActive"></slot>
    </div>
    <span
      class="nav-link-text ms-1"
      >{{ navText }}</span
    >
  </Link>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
  name: 'sidenav-collapse',
  components: {
    // eslint-disable-next-line vue/no-reserved-component-names
    Link,
  },
  props: {
    to: {
      type: [Object, String],
      default: '#',
    },
    navText: {
      type: String,
      required: true,
    },
  },
  data () {
    return {
      isExpanded: false,
    }
  },

  computed: {
    isActive () {
      const to = typeof this.to === 'string' ? this.to : this.to.name
      return this.$page.component.includes(to)
    },
  },
}
</script>
