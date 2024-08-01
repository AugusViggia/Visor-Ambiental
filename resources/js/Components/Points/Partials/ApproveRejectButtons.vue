<template>

  <button class="btn btn-success me-2" title="Aprobar punto" @click.prevent="setPointToApproveOrDeny(props.point, true)">
    Aprobar
  </button>

  <button class="btn btn-danger me-2" title="Rechazar punto" @click.prevent="setPointToApproveOrDeny(props.point, false)">
    Rechazar
  </button>

  <JetDialogModal id="approveDenyModal">
    <template #title>
      {{ approvingPoint ? 'Aprobar punto' : 'Rechazar punto' }}
    </template>
    <template #content>
      <div v-if="approvingPoint">
        <div class="alert alert-info text-white" role="alert">
          ¿Estás seguro que deseas aprobar este Punto?
        </div>
        <strong>Título: </strong> {{ pointToApproveOrDeny.title }}
        <div class="row">
          <div class="col">
            <strong>Ecorregión: </strong> {{ pointToApproveOrDeny.ecoregion.name }}
          </div>
          <div class="col">
            <strong>Biota: </strong> {{ pointToApproveOrDeny.subcategory.name }}
          </div>
        </div>
        <strong>Fuente: </strong> {{ pointToApproveOrDeny.source }}
      </div>
      <div v-else>
        <div class="alert alert-warning" role="alert">
          ¿Estás seguro que deseas rechazar este Punto?
        </div>
        <div class="mb-2">
          <JetLabel>Motivo</JetLabel>
          <JetTextarea
            v-model="approveDenyPointForm.reason"
            placeholder="Motivo del rechazo"
            :class="{ 'is-invalid': approveDenyPointForm.errors.reason }"
          />
          <JetInputError v-if="approveDenyPointForm.errors.reason" :message="approveDenyPointForm.errors.reason" />
        </div>
      </div>
    </template>
    <template #footer>
      <jet-button
        v-if="pointToApproveOrDeny"
        :class="[approvingPoint ? 'btn-success' : 'btn-danger']"
        title="Confirmar"
        :disabled="approveDenyPointForm.processing"
        @click.prevent="handleApproveDenyPoint"
      >
        <div v-show="approveDenyPointForm.processing" class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">{{ $__('Loading...') }}</span>
        </div>
        {{ $__('Confirmar') }}
      </jet-button>
      <jet-secondary-button data-dismiss="modal" @click="closeApproveDenyModal" :title="$__('Cancel')">
        {{ $__('Cancel') }}
      </jet-secondary-button>
    </template>

  </JetDialogModal>

</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '@/Jetstream/Button'
import JetLabel from '@/Jetstream/Label'
import JetTextarea from '@/Jetstream/Textarea'
import JetInputError from '@/Jetstream/InputError'

const props = defineProps({
  point: Object,
})

const approveDenyModal = ref(null)
const pointToApproveOrDeny = ref(null)
const approvingPoint = ref(null)
const approveDenyPointForm = useForm({
  reason: null,
})

function openApproveDenyModal () {
  const el = document.querySelector('#approveDenyModal')
  approveDenyModal.value = new bootstrap.Modal(el)
  approveDenyModal.value.show()
}

function setPointToApproveOrDeny (point, approving) {
  pointToApproveOrDeny.value = point
  approvingPoint.value = approving
  openApproveDenyModal()
}

function approvePoint () {
  approveDenyPointForm.put(route('points.approve', pointToApproveOrDeny.value.id))
}

function denyPoint () {
  approveDenyPointForm.put(route('points.reject', pointToApproveOrDeny.value.id), {
    onSuccess: () => {
      closeApproveDenyModal()
      approveDenyPointForm.reset()
    },
  })
}

function closeApproveDenyModal () {
  approveDenyModal.value.hide()
}

function handleApproveDenyPoint () {
  if (approvingPoint.value) {
    approvePoint()
    closeApproveDenyModal()
    return
  }
  denyPoint()
}
</script>
