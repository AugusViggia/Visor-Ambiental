<template>
  <table class="table table-sm table-hover table-striped table-light">
    <thead>
    <tr>
      <th></th>
      <th>Nombre y Apellido</th>
      <th>Nro. de Documento</th>
      <th>Email</th>
      <th>Usuario</th>
      <th class="text-center">Creado</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="request in list" :key="request.id">
      <td>
        <a href="#" title="Ver Solicitud" class="p-2 me-1" @click.prevent="showRejectionDetail(request)">
          <i class="fa-solid fa-eye"></i>
        </a>
        <a  class="p-2" @click="onDeleteSolicitud(request)" title="Eliminar Solicitud">
              <i class="far fa-trash-alt"></i>
            </a>
      </td>
      <td>{{ request.name }}</td>
      <td class="text-center">{{ request.document_number }}</td>
      <td>{{ request.email }}</td>
      <td>{{ request.rejection.user_who_approved?.name }}</td>
      <td class="text-center">{{ $dateFormat(request.requested_at) }}</td>
    </tr>
    </tbody>
  </table>
  <JetDialogModal id="rejectionDetailModal">
      <template #title>
        {{ $__("Detalle de rechazo") }}
      </template>
      <template #content>
        <div v-if="rejectionToDisplay">
          <p><i class="fas fa-user-alt-slash"></i> <strong><u>Nombre</u>: </strong>{{ rejectionToDisplay.name }}</p>
          <p><i class="fas fa-question-circle"></i> <strong><u>Motivo</u>: </strong>{{ rejectionToDisplay.rejection.reason }}</p>
        </div>
      </template>
      <template #footer>
          <jet-secondary-button data-dismiss="modal" @click="closeModal" :title="$__('Cancel')">
            {{ $__('Cancel') }}
          </jet-secondary-button>
      </template>
    </JetDialogModal>
  <JetDialogModal id="deleteSolucitudModal">
      <template #title>
        {{ $__("Eliminar") }}
      </template>
      <template #content>
        <div class="alert alert-warning" role="alert">
          ¿Estás seguro que deseas eliminar esta Solicitud?
        </div>
      </template>
      <template #footer>
        <jet-button title="Confirmar" class="btn-danger" :class="[loading ? 'text-white-50' : 'text-white']" @click.prevent="deleteSoliditud" :disabled="loading">
          <div v-show="loading" class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">{{ $__('Loading...') }}</span>
          </div>
            {{ $__('Confirmar') }}
          </jet-button>
          <jet-secondary-button data-dismiss="modal" @click="closeModalDelete" :title="$__('Cancel')">
            {{ $__('Cancel') }}
          </jet-secondary-button>
      </template>
    </JetDialogModal>
</template>

<script setup>
import { ref } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetButton from '@/Jetstream/Button'
import { Inertia } from '@inertiajs/inertia'
// import route from '../../../../../vendor/tightenco/ziggy/src/js'
import route from '@/ziggy'

// eslint-disable-next-line no-unused-vars
const props = defineProps({
  list: {
    type: Array,
    required: true,
  },
})

const rejectionToDisplay = ref(null)
const modal = ref(null)
const requestDelete = ref(null)
const loading = ref(false)

const showRejectionDetail = (request) => {
  const el = document.querySelector('#rejectionDetailModal')
  rejectionToDisplay.value = request
  modal.value = new bootstrap.Modal(el)
  modal.value.show()
}

function deleteSoliditud () {
  loading.value = true
  Inertia.delete(route('userRequests.reject.delete', { id: requestDelete.value.id }), {
    onSuccess: () => {
      closeModalDelete()
      loading.value = false
    },
  })
}

function onDeleteSolicitud (request) {
  requestDelete.value = request
  showRejectionDelete()
}

function showRejectionDelete () {
  const el = document.querySelector('#deleteSolucitudModal')
  modal.value = new bootstrap.Modal(el)
  modal.value.show()
}

function closeModalDelete () {
  modal.value.hide()
}

const closeModal = () => {
  modal.value.hide()
}
</script>
