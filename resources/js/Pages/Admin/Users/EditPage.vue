<template>
  <InertiaHead title="Editar datos de usuario" />
  <div class="card">
    <div class="card-body">
      <h5>Editar datos de usuario</h5>
      <EditForm :roles="props.roles" :user="props.user" />
    </div>
  </div>
</template>

<script setup>
import { InertiaHead } from '@inertiajs/inertia-vue3'
import EditForm from '@/Components/Users/CreateEditForm'

const props = defineProps({
  roles: Object,
  user: Object,
})

</script>
