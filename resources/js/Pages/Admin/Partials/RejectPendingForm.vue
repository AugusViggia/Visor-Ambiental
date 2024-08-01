<template>
  <JetDialogModal id="rejectPendingForm">
    <template #title>
      {{ $__('Rechazar') }}
    </template>

    <template #content>
      <div class="alert alert-warning">
        ¿Estas seguro de rechazar esta solicitud?
      </div>

      <p v-if="data.value">
        <strong>Apellido y Nombres:</strong> {{ data.value.name }}<br>
        <strong>E-mail:</strong> {{ data.value.email }}
      </p>

      <JetLabel for="reason">Motivo</JetLabel>
      <JetTextarea
        v-model="form.reason"
        id="reason"
        placeholder="Motivo"
        :error="data.errors.reason"
      />
      <JetInputError v-if="data.errors.reason" :message="data.errors.reason" />
    </template>

    <template #footer>
      <jet-button class="btn-danger ms-2" @click="reject" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
        <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">{{ $__('Loading...') }}</span>
        </div>

        {{ $__('Confirmar') }}
      </jet-button>

      <jet-secondary-button class="btn btn-secondary" data-dismiss="modal" @click="closeModal">
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
import JetLabel from '@/Jetstream/Label'
import JetInputError from '@/Jetstream/InputError'
import JetTextarea from '@/Jetstream/Textarea'

const form = useForm({ reason: null })

const data = reactive(
  {
    modal: null,
    value: null,
    errors: {},
  }
)

defineExpose({ show })

function show (payload) {
  resetState()
  data.value = payload
  showModal('#rejectPendingForm')
}

function reject () {
  const user = data.value
  form.delete(
    route('userRequests.reject', { user }),
    {
      preserveScroll: false,
      onSuccess: () => {
        closeModal()
        resetState()
      },
      onError: (error) => {
        data.errors = error
      },
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
}

function resetState () {
  form.reset()
  data.errors = {}
}
</script>
