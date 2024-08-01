<template>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="table-light text-black-50">
        <tr>
          <th scope="col">Opciones</th>
          <th scope="col"> Punto</th>
          <th scope="col">Título</th>
          <th scope="col">Descripción</th>
          <th scope="col">Ecorregión</th>
          <th scope="col">Categoría</th>
          <th scope="col">Subcategoría</th>
          <th scope="col">Fuente</th>
          <th scope="col">Altura</th>
          <th v-if="isAdmin" scope="col">Usuario</th>
          <th scope="col">Estado</th>
          <th scope="col">Ultima modifación</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="point in props.points.data" :key="point.id">
          <td>
            <Link v-if="isAdmin" class="p-2" :title="pointIsPending(point) ? 'Procesar punto' : 'Ver punto'" :href="processOrShowUrl(point)">
              <i class="far fa-eye"></i>
            </Link>
            <Link v-else class="p-2" :title="'Ver punto'" :href="showPoint(point)">
              <i class="far fa-eye"></i>
            </Link>
            <Link v-if="point.can_update" class="p-2" title="Editar punto" :href="route('points.edit',{id:point.id})">
              <i class="far fa-edit"></i>
            </Link>
            <a href="#" v-if="pointIsApproved(point) && isAdmin" class="p-2" title="Denunciar punto" @click.prevent="openReportForm(point)">
              <i class="far fa-thumbs-down"></i>
            </a>
            <a v-if="point.can_delete" class="p-2" @click="onDeletePoint(point)" title="Eliminar punto">
              <i class="far fa-trash-alt"></i>
            </a>

          </td>
          <td class="text-end">{{ point.id }}</td>
          <td>{{ point.title }}</td>
          <td> <div class="reponsive overflow-auto"> {{ point.description }} </div></td>
          <td>{{ point.ecoregion.name }}</td>
          <td>{{ point.category.name }}</td>
          <td>{{ point.subcategory.name }}</td>
          <td>{{ point.source }}</td>
          <td class="text-end">{{ point.altitude }}</td>
          <td v-if="isAdmin">{{ point.user.name }}</td>
          <td>{{ point.status.name }}</td>
          <td class="text-center">{{ $dateFormat(point.date_last_modified) }}</td>
        </tr>
      </tbody>
    </table>
    <Pagination class="mt-6" :links="props.points.links" :meta="props.points.meta" />
  </div>
  <JetDialogModal id="deletePointModal">
    <template #title>
      {{ $__('Eliminar') }}
    </template>
    <template #content>
      <div class="alert alert-warning" role="alert">
        ¿Estás seguro que deseas eliminar este Punto ?
      </div>
      <div class="row">
        <div class="col-6">
          <strong>Punto: </strong> {{ pointDelete?.id }}
        </div>
        <div class="col-6">
          <strong>Título: </strong> {{ pointDelete?.title }}
        </div>
      </div>
      <div>
        <strong>Descripción: </strong> {{ pointDelete?.description ?? '' }}
      </div>
    </template>
    <template #footer>
      <jet-button v-if="pointDelete" title="Confirmar" class="btn-danger" @click.prevent="deletePoint" :disabled="loading">
        <div v-show="loading" class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">{{ $__('Loading...') }}</span>
        </div>
        {{ $__('Confirmar') }}
      </jet-button>
      <jet-secondary-button data-dismiss="modal" @click="closeModal" :title="$__('Cancel')">
        {{ $__('Cancel') }}
      </jet-secondary-button>
    </template>

  </JetDialogModal>
  <ReportPoint ref="reportPointModal" isOnMainList/>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import { getCurrentInstance, ref, computed } from 'vue'
import Pagination from '../Pagination'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '../../Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import { Inertia } from '@inertiajs/inertia'
import ReportPoint from '../../Components/Map/ReportPoint'

const modal = ref(null)
const pointDelete = ref(null)
const loading = ref(false)

const props = defineProps({
  points: Object,
  pointStatusList: {
    type: Object,
    default: null,
  },
})

const gates = getCurrentInstance().appContext.app.config.globalProperties.$gates
const isAdmin = computed(() => {
  return gates.hasRole('ADM')
})

function deletePoint () {
  loading.value = true
  Inertia.delete(route('points.delete', { id: pointDelete.value.id }), {
    onSuccess: () => {
      closeModal()
      loading.value = false
    },
    onError: () => {
      loading.value = false
      return null
    },
  })
}

function onDeletePoint (point) {
  pointDelete.value = point
  openModal()
}

function openModal () {
  const el = document.querySelector('#deletePointModal')
  modal.value = new bootstrap.Modal(el)
  modal.value.show()
}

function closeModal () {
  modal.value.hide()
}

function pointIsPending (point) {
  return point.status.id === props.pointStatusList.pending
}

function pointIsApproved (point) {
  return point.status.id === props.pointStatusList.approved
}

function processOrShowUrl (point) {
  const isPending = pointIsPending(point)
  if (isPending) {
    return route('points.process', point.id)
  }
  return route('points.show', point.id)
}

function showPoint (point) {
  return route('points.show', point.id)
}

const reportPointModal = ref(null)
function openReportForm (point) {
  reportPointModal.value.show(point)
}

</script>
<style scoped>
.reponsive {
  max-width: 240px;
  overflow: hidden;
}
</style>
