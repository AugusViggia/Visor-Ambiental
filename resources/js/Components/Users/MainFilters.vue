<template>

  <form @submit.prevent="handleForm">
    <div class="row">
      <div class="col-lg-3 mb-3">
        <JetLabel>Nombre y apellido</JetLabel>
        <JetInput v-model="form.name" placeholder="Nombre" />
      </div>
      <div class="col-lg-3 mb-3">
      <JetLabel>Número Documento</JetLabel>
        <JetInput v-model="form.document_number" type="number" placeholder="Número Documento" />
      </div>
      <div class="col-lg-3 mb-3">
        <JetLabel>Estado</JetLabel>
        <select v-model="form.enabled" class="form-control">
          <option value="">Ambos</option>
          <option :value="1">Habilitado</option>
          <option :value="0">Bloqueado</option>
        </select>
      </div>
      <div class="col-lg-3 d-flex">
        <JetButton class="btn-success text-white mt-auto" title="Filtrar búsqueda"><i class="fas fa-search"></i></JetButton>
        <JetButton
          v-if="props.filters"
          class="btn-secondary mt-auto ms-2"
          title="Limpiar búsqueda"
          @click.prevent="cleanSearch"
        >
          <i class="fas fa-times"></i>
        </JetButton>
      </div>
    </div>
  </form>

</template>

<script setup>
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetButton from '@/Jetstream/Button.vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
  filters: {
    type: Object,
    default: null,
  },
})

const form = useForm({
  name: props.filters ? props.filters.name : '',
  document_number: props ? props.filters?.document_number : '',
  enabled: props ? props.filters ? props.filters.enabled ?? '' : '' : '',
})

const handleForm = () => {
  form.get(route('users.index'))
}

const cleanSearch = () => {
  Inertia.get(route('users.index'))
}

</script>
