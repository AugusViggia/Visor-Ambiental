<template>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="table-light text-black-50">
        <tr>
          <th scope="col" v-if="props.optionsShow"> </th>
          <th scope="col">Fecha</th>
          <th scope="col">Nro. Taxones</th>
          <th scope="col">Descripción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(observation,index) in dataObservations" :key="index">
          <td v-if="props.optionsShow">
            <a class="p-2" title="Eliminar" @click="setToDelete(index,observation)">
              <i class="far fa-trash-alt"></i>
            </a>
          </td>
          <td>{{ $dateFormat(observation.date) }}</td>
          <td>{{  observation.taxa }}</td>
          <td>{{ observation.description }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <JetDialogModal id="deleteObservationModal">
      <template #title>
          {{ $__('Eliminar') }}
      </template>
      <template #content>
          <div class="alert alert-warning" role="alert">
              ¿Estás seguro que deseas eliminar este avistamieno?
          </div>
          <div>
            <strong>Fecha: </strong> {{ doDelete?.date }}
          </div>
          <div>
            <strong>Nro. Taxones: </strong> {{ doDelete?.taxa }}
          </div>
          <div>
            <strong>Descripción: </strong> {{ doDelete?.description }}
          </div>
      </template>
      <template #footer>
          <jet-button
            v-if="doDelete"
            class="btn-danger"
            title="Confirmar"
            @click.prevent="deleteOservation"
            :disabled="form.processing"
          >
            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">{{ $__('Loading...') }}</span>
            </div>
            {{ $__('Confirmar') }}
          </jet-button>
          <jet-secondary-button data-dismiss="modal" @click="closeModal" :title="$__('Cancel')">
            {{ $__('Cancel') }}
          </jet-secondary-button>
      </template>

    </JetDialogModal>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import { computed, ref } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import { useForm } from '@inertiajs/inertia-vue3'

const props = defineProps({
  observations: Array,
  point: Object,
  rejecting: Boolean,
  optionsShow: Boolean,
})

const form = useForm({})
const modal = ref(null)

const emit = defineEmits(['delete'])
const doDelete = ref(null)
const indexDelete = ref(null)

function setToDelete (index, observation) {
  if (props.point) {
    doDelete.value = observation
  } else {
    doDelete.value = props.observations[index]
    indexDelete.value = index
  }
  openModal()
}

function rejectObservation () {
  Inertia.delete(route('observations.reject', doDelete.value.id), {
    onSuccess: () => closeModal(),
  })
}

function deleteOservation () {
  if (props.rejecting) {
    rejectObservation()
    return
  }
  if (props.point) {
    return form.delete(route('observations.delete', { id: doDelete.value.id }), {
      onSuccess: () => closeModal(),
    })
  }
  emit('delete', indexDelete.value)
  closeModal()
}

const dataObservations = computed(() => {
  if (props.point) {
    return props.point.observations
  }
  return props.observations
})

function openModal () {
  const el = document.querySelector('#deleteObservationModal')
  modal.value = new bootstrap.Modal(el)
  modal.value.show()
}

function closeModal () {
  modal.value.hide()
}

</script>
