<template>
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li v-for="{type, name, active} in types" :key="type" class="nav-item">
                <Link
                  :class="['nav-link', active ? 'active' : '']"
                  :aria-current="active ? 'true' : 'false'"
                  :href="route('userRequests.index', { type })"
                >
                  {{ name }}
                </Link>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'

// eslint-disable-next-line no-unused-vars
const props = defineProps({
  types: {
    type: [Array, Object],
    required: true,
  },
})
</script>
