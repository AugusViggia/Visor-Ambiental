<template>
  <table class="table table-sm table-hover table-striped table-light">
    <thead>
    <tr>
      <th></th>
      <th>Nombre y Apellido</th>
      <th>Nro. de Documento</th>
      <th>Email</th>
      <th>Institución</th>
      <th class="text-center">Creado</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="request in list" :key="request.id">
      <td>
        <a
          href="#"
          @click.prevent="confirmAcceptPending(request)"
          title="Aceptar Solicitud"
          class="p-2 me-1"
        >
          <i class="fa-solid fa-user-check"></i>
        </a>
        <a
          href="#"
          @click.prevent="confirmRejectPending(request)"
          title="Rechazar Solicitud"
          class="p-2"
        >
          <i class="fa-solid fa-user-xmark"></i>
        </a>
      </td>
      <td>{{ request.name }}</td>
      <td class="text-center">{{ request.document_number }}</td>
      <td>{{ request.email }}</td>
      <td>{{ request.institution }}</td>
      <td class="text-center">{{ $dateFormat(request.requested_at) }}</td>
    </tr>
    </tbody>
  </table>

  <AcceptPendingForm ref="acceptPendingForm" />

  <RejectPendingForm ref="rejectPendingForm" />
</template>

<script setup>
import { ref } from 'vue'
import AcceptPendingForm from '@/Pages/Admin/Partials/AcceptPendingForm'
import RejectPendingForm from '@/Pages/Admin/Partials/RejectPendingForm'

const acceptPendingForm = ref(null)

const rejectPendingForm = ref(null)

// eslint-disable-next-line no-unused-vars
const props = defineProps({
  list: {
    type: Array,
    required: true,
  },
})

function confirmAcceptPending (request) {
  acceptPendingForm.value.show(request)
}

function confirmRejectPending (request) {
  rejectPendingForm.value.show(request)
}
</script>
