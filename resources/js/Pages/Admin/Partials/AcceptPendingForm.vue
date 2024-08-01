<template>
  <JetDialogModal id="acceptPendingForm">
    <template #title>
      {{ $__('Habilitar') }}
    </template>

    <template #content>
      <div class="alert alert-info text-white">
        ¿Estas seguro de aceptar esta solicitud?
      </div>

      <p v-if="data.value">
        <strong>Apellido y Nombres:</strong> {{ data.value.name }}<br>
        <strong>E-mail:</strong> {{ data.value.email }}
      </p>
    </template>

    <template #footer>
      <jet-button class="btn btn-block bg-success ms-2" @click="accept" :class="[ form.processing ? 'text-white-50' : 'text-white' ]" :disabled="form.processing">
        <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">{{ $__('Loading...') }}</span>
        </div>

        {{ $__('Confirmar') }}
      </jet-button>

      <jet-secondary-button data-dismiss="modal" class="btn btn-secondary" @click="closeModal">
        {{ $__('Cancel') }}
      </jet-secondary-button>
    </template>
  </JetDialogModal>
</template>

<script setup>
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { reactive } from 'vue'

const form = useForm({})

const data = reactive(
  {
    modal: null,
    value: null,
  }
)

defineExpose({ show })

function show (payload) {
  data.value = payload
  showModal('#acceptPendingForm')
}

function accept () {
  const user = data.value
  form.patch(
    route('userRequests.accept', { user }),
    {
      preserveScroll: false,
      onSuccess: () => closeModal(),
    }
  )
}

function showModal (modalId) {
  const el = document.querySelector(modalId)
  data.modal = new bootstrap.Modal(el)
  data.modal.show()
}

function closeModal () {
  data.modal.hide()
  form.reset()
}
</script>
