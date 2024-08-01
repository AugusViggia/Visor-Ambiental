<template>
  <InertiaHead title="Nuevo usuario" />
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-body">
        <h5>Nuevo usuario</h5>
        <CreateForm :roles="props.roles" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { InertiaHead } from '@inertiajs/inertia-vue3'
import CreateForm from '@/Components/Users/CreateEditForm'

const props = defineProps({
  roles: Object,
})
</script>
