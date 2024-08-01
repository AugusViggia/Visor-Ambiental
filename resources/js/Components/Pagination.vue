<template>
  <div class="d-flex justify-content-between align-items-center">
    <nav aria-label="Paginación">
      <ul v-if="meta.total > meta.per_page" class="pagination">
        <li
          v-for="link in meta.links"
          :key="link.label"
          class="page-item"
          :class="{'active' : link.active, 'disabled': link.url === null }"
        >
          <!-- eslint-disable-next-line vue/no-v-text-v-html-on-component -->
          <Link class="page-link" :href="link.url" v-html="link.label" />
        </li>
      </ul>
    </nav>
    <span
      class="badge rouded-pill bg-light text-secondary fw-normal text-capitalize pb-3 pt-3 mb-3"
    >
      Registros: {{ meta.from }} - {{ meta.to }} | Total: {{ meta.total }}
    </span>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'

// eslint-disable-next-line no-unused-vars,no-undef
const props = defineProps({
  meta: {
    type: Object,
    required: true,
  },
  links: {
    type: Object,
    required: true,
  },
})
</script>
