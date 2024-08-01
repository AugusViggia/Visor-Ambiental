<template>
  <div id="modalCraete">
    <div class="d-flex justify-content-between">
      <h6 class="card-text">Avistamiento</h6>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end" v-if="showButton()">
        <a @click.prevent="openModal" class="btn btn-outline-success"
          ><i class="fas fa-plus"></i> Agregar avistamiento</a
        >
      </div>
    </div>

    <JetDialogModal id="addObservationModal">

      <template #title>
        {{ $__("Agregar avistamiento") }}
      </template>
      <template #content>
         <div class="mb-2">
        <jet-label for="date" value="Fecha" />
        <jet-Input
          ref="date"
          type="date"
          v-model="form.date"
          placeholder="Ingrese fecha"
          :class="{ 'is-invalid': errors.date }"
        />
        <jet-input-error
          v-if="errors.date"
          :message="getErrorMessage(errors.date)"
        />
      </div>
      <div class="mb-2">
        <jet-label for="taxa" value="Nro. taxones" />
        <jet-Input
          type="number"
          v-model="form.taxa"
          placeholder="Ingrese taxa"
          :class="{ 'is-invalid': errors.taxa }"
        />
        <jet-input-error
          v-if="errors.taxa"
          :message="getErrorMessage(errors.taxa)"
        />
      </div>
      <div class="mb-2">
        <jet-label for="description" value="Descripción" />
        <jet-text-area
          v-model="form.description"
          type="text"
          id="description"
          :class="{ 'is-invalid': errors.description }"
          placeholder="Ingrese descripción"
        ></jet-text-area>
        <jet-input-error
          v-if="errors.description"
          :message="getErrorMessage(errors.description)"
        />
      </div>
      </template>

      <template #footer>
          <jet-button v-if ="!props.point" @click="processObservationAxios" class="btn-success" :class="[ loading ? 'text-white-50' : 'text-white' ]" :disabled="loading">
            <div v-show="loading" class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">{{ $__("Loading...") }}</span>
            </div>

            {{ $__("Confirmar") }}
          </jet-button>
          <jet-button v-else @click="saveObservation" class="ms-2 btn-success"  :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
        <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">{{ $__('Loading...') }}</span>
        </div>

        {{ $__('Confirmar') }}
      </jet-button>
          <jet-secondary-button data-dismiss="modal" @click="closeModal">
            {{ $__('Cancel') }}
          </jet-secondary-button>
        </template>
    </JetDialogModal>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import JetLabel from '@/Jetstream/Label'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetTextArea from '@/Jetstream/Textarea'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import Errors from '../../Composable/Errors'

const props = defineProps({
  point: Object,
  errors: Object,
  sizeObservations: Number,
})

const date = ref(null)

const form = useForm({
  date: null,
  taxa: null,
  description: null,
})

const emit = defineEmits(['success'])

const modal = ref(null)
const loading = ref(false)

const errorsAxios = ref(null)
const { getErrorMessage } = Errors()

const errors = computed(() => {
  if (errorsAxios.value) {
    return errorsAxios.value
  }
  return props.errors
})

function saveObservation () {
  form.post(route('observations.store', { id: props.point.id }), {
    preserveState: true,
    onSuccess: () => {
      closeModal()
      form.reset()
    },
  })
}

function processObservationAxios () {
  loading.value = true
  axios.post(route('api.observations.process'), form)
    .then((res) => {
      loading.value = false
      emit('success', res.data)
      form.reset()
      closeModal()
    })
    .catch((err) => {
      const status = err.response.status
      loading.value = false
      if (status === 422) {
        errorsAxios.value = err.response.data.errors
      }
    })
}

function showButton () {
  if (!props.point && props.sizeObservations < 1) {
    return true
  } else if (props.point) {
    return true
  }

  return false
}

function openModal () {
  const el = document.querySelector('#addObservationModal')
  modal.value = new bootstrap.Modal(el)
  modal.value.show()
}

function closeModal () {
  modal.value.hide()
}

</script>
