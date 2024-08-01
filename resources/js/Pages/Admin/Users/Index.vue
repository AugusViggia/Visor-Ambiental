<template>
  <InertiaHead title="Consulta de usuarios" />
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h5>Consulta de usuarios</h5>
        <Link :href="route('users.create')" class="btn btn-outline-success" title="Alta de usuario">
          <i class="fas fa-plus"></i> Nuevo Usuario
        </Link>
      </div>
      <MainFilters :filters="props.filters" />
      <MainTable v-if="props.users.data.length > 0" :users="props.users.data" />
      <Pagination v-if="props.users.data.length > 0" class="mt-6" :links="props.users.links" :meta="props.users.meta" />
      <ActionMessage
            :on="props.users.data.length === 0"
            custom-class="alert-sucess text-white"
          >
            {{ $__("No results.") }}
          </ActionMessage>
    </div>
  </div>
</template>

<script setup>
import { InertiaHead, Link } from '@inertiajs/inertia-vue3'
import MainFilters from '@/Components/Users/MainFilters'
import MainTable from '@/Components/Users/MainTable'
import Pagination from '@/Components/Pagination'
import ActionMessage from '../../../Jetstream/ActionMessage'

const props = defineProps({
  users: Object,
  filters: Object,
})
</script>
