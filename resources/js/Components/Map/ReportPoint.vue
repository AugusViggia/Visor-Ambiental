<template>
  <JetDialogModal id="denounceForm">
    <template #title>
      {{ $__('Denunciar') }}
    </template>

    <template #content>
      <div class="alert alert-warning">
        ¿Estas seguro de observar este punto?
      </div>

      <p v-if="data.value">
        <strong>Título:</strong> {{ data.value.title }}<br>
        <strong>Descripción:</strong> {{ data.value.description }}
      </p>

      <JetLabel for="reason">Motivo</JetLabel>
      <JetTextarea
        v-model="form.reason"
        id="reason"
        placeholder="Motivo"
        :error="data.errors.reason ? data.errors.reason[0] : null"
      />
      <JetInputError v-if="data.errors.reason" :message="data.errors.reason[0]" />
    </template>

    <template #footer>
      <jet-button
        class="ms-2 btn-danger"
        @click="send"
        :class="{ 'text-white-50': form.processing }"
        :disabled="data.loading"
      >
        <div
          v-show="data.loading"
          class="spinner-border spinner-border-sm"
          role="status"
        >
          <span class="visually-hidden">{{ $__('Loading...') }}</span>
        </div>

        {{ $__('Confirmar') }}
      </jet-button>

      <jet-secondary-button data-dismiss="modal" @click="closeModal">
        {{ $__('Cancel') }}
      </jet-secondary-button>
    </template>
  </JetDialogModal>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { reactive } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetLabel from '@/Jetstream/Label'
import JetInputError from '@/Jetstream/InputError'
import JetTextarea from '@/Jetstream/Textarea'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  isOnMainList: {
    type: Boolean,
    default: false,
  },
})

const form = useForm({ reason: null })

const data = reactive(
  {
    modal: null,
    value: null,
    errors: {},
    loading: false,
  }
)

function showModal (modalId) {
  const el = document.querySelector(modalId)
  // eslint-disable-next-line no-undef
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

function show (payload) {
  resetState()
  data.value = payload
  showModal('#denounceForm')
}

function reloadPage () {
  window.location.reload()
}

async function send () {
  data.loading = true
  data.errors = {}
  let { id } = data.value
  if (props.isOnMainList) {
    id = data.value.resource_id
  }
  const payload = {
    reason: form.reason,
  }
  try {
    await axios.patch(route('map.denounce', { point: id }), payload)
    if (!props.isOnMainList) {
      reloadPage()
      return
    }
    closeModal()
    resetState()
    Inertia.reload()
  } catch (error) {
    const status = error.response?.status
    if (status === 422) {
      data.errors = error.response.data.errors
      return
    }
    if (!props.isOnMainList) {
      reloadPage()
      return
    }
    closeModal()
    resetState()
    Inertia.reload()
  } finally {
    data.loading = false
  }
}

defineExpose({ show })
</script>
