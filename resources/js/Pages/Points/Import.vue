<template>
  <Head>
    <title>Importar Puntos Excel</title>
  </Head>
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
          <h5>Importar Puntos Excel</h5>
        </div>
        <ImportForm
          v-if="!unexpectedError"
          :categories="props.categories"
          :ecoregions="props.ecoregions"
          @successImport="onSuccessImport"
          @fileHasErrors="onFileHasErrors"
          @unexpectedError="onUnexpectedError"
        />
        <div v-else class="card card-frame border border-danger">
          <div class="card-body">
            <strong>Hubo un error inesperado.</strong>
            <ul>
              <li>Es posible que el archivo subido no corresponda con el formato esperado.</li>
              <li>Si el error persiste, comunicarlo a un administrador.</li>
            </ul>
            <Button class="btn-primary mt-3" @click.prevent="reloadPage">Recargar página</Button>
          </div>
        </div>
        <div
          v-if="importResponse"
          class="card card-frame border border-success"
        >
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-lg-4">
                <DataField label="Estado" text="Finalizada" />
              </div>
              <div class="col-lg-4">
                <DataField
                  label="Fecha y Hr. de Inicio"
                  :text="$timestampFormat(importResponse.start_time)"
                />
              </div>
              <div class="col-lg-4">
                <DataField
                  label="Fecha y Hr. de Finalización"
                  :text="$timestampFormat(importResponse.end_time)"
                />
              </div>
            </div>
            <h6 class="text-success mb-3">
              <strong>La importación finalizó correctamente.</strong>
            </h6>
          </div>
        </div>
        <div v-if="fileHasErrors" class="card card-frame border border-danger">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-lg-4">
                <DataField label="Estado" text="Finalizada" />
              </div>
              <div class="col-lg-4">
                <DataField
                  label="Fecha y Hr. de Inicio"
                  :text="$timestampFormat(fileHasErrorsResponse.start_time)"
                />
              </div>
              <div class="col-lg-4">
                <DataField
                  label="Fecha y Hr. de Finalización"
                  :text="$timestampFormat(fileHasErrorsResponse.end_time)"
                />
              </div>
            </div>
            <h6 class="text-danger mb-3">
              <strong>Ha ocurrido un error en la importación</strong>
            </h6>
            <Button
              type="button"
              class="btn-success mb-3"
              @click.prevent="downloadCsvWithErrors"
              title="Descargar CSV con errores"
            >
              Error de validación ({{
                fileHasErrorsResponse.failed_rows_count
              }}) <i class="fas fa-file-csv"></i>
            </Button>
            <h6 class="text-dark mb-3">
              <strong
                >Para continuar tú deberás corregir los errores y realizar la
                importación nuevamente</strong
              >
            </h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/inertia-vue3'
import ImportForm from '../../Components/Points/ImportForm.vue'
import DataField from '../../Components/Common/DataField.vue'
import Button from '../../Jetstream/Button.vue'

const props = defineProps({
  categories: {
    type: Object,
    required: true,
  },
  ecoregions: {
    type: Object,
    required: true,
  },
})

const importResponse = ref(null)
const fileHasErrors = ref(false)
const fileHasErrorsResponse = ref(null)
const unexpectedError = ref(false)

function onSuccessImport (res) {
  importResponse.value = res
}

function onFileHasErrors (data) {
  fileHasErrors.value = true
  fileHasErrorsResponse.value = data
}

function onUnexpectedError () {
  unexpectedError.value = true
}

function downloadCsvWithErrors () {
  const blob = new Blob([fileHasErrorsResponse.value.csv], {
    type: 'text/csv',
  })
  const url = window.URL.createObjectURL(blob)
  const link = document.createElement('a')
  link.href = url
  link.download = 'detalles.csv'
  link.click()
  window.URL.revokeObjectURL(url)
}

function reloadPage () {
  window.location.reload()
}
</script>
