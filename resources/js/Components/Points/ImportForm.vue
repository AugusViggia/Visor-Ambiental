<template>
  <form @submit.prevent="submit">
    <div class="row">
      <div class="col-lg-4 mb-2">
        <Label>Categoría</Label>
        <vSelect
          :options="props.categories"
          label="name"
          v-model="form.category_id"
          :reduce="(category) => category.id"
          @option:selected="() => (form.subcategory_id = null)"
          :class="{ 'is-invalid': errors.hasOwnProperty('category_id') }"
        >
          <template #no-options> Sin resultados </template>
        </vSelect>
        <InputError
          v-if="errors.hasOwnProperty('category_id')"
          :message="errors.category_id[0]"
        ></InputError>
      </div>

      <div class="col-lg-4 mb-2">
        <Label>Subcategoría</Label>
        <vSelect
          :options="subcategories"
          label="name"
          v-model="form.subcategory_id"
          :reduce="(subcategory) => subcategory.id"
          :class="{ 'is-invalid': errors.hasOwnProperty('subcategory_id') }"
        >
          <template #no-options> Sin resultados </template>
        </vSelect>
        <InputError
          v-if="errors.hasOwnProperty('subcategory_id')"
          :message="errors.subcategory_id[0]"
        ></InputError>
      </div>

      <div class="col-lg-4 mb-2">
        <Label>Ecoregión</Label>
        <vSelect
          :options="props.ecoregions"
          label="name"
          v-model="form.ecoregion_id"
          :reduce="(ecoregion) => ecoregion.id"
          :class="{ 'is-invalid': errors.hasOwnProperty('ecoregion_id') }"
        >
          <template #no-options> Sin resultados </template>
        </vSelect>
        <InputError
          v-if="errors.hasOwnProperty('ecoregion_id')"
          :message="errors.ecoregion_id[0]"
        ></InputError>
      </div>
    </div>

    <div class="card card-frame mt-3 shadow bg bg-light">
      <div class="card-body">
        <i class="fas fa-info-circle"></i>
        Utilizá esta plantilla de cálculo
          <span class="badge bg-secondary">
            <a :href="route('points.importacion.download-excel-template')">
              <i class="fas fa-download text-white" title="Descargar plantilla CSV"></i>
            </a>
          </span> para importar sus puntos
      </div>
    </div>

    <div class="mb-2 mt-3">
      <Label>Adjuntar archivo</Label>
      <Input
        type="file"
        :class="{ 'is-invalid': errors.hasOwnProperty('file') }"
        @input="setFile"
      />
      <InputError
        v-if="errors.hasOwnProperty('file')"
        :message="errors.file[0]"
      ></InputError>
    </div>

    <div v-if="canShowSubmitButton" class="mb-4 mt-4">
      <Button
        class="btn-info btn-lg w-100 shadow"
        title="Iniciar importación"
        :disabled="loading"
      >
        <template v-if="!loading">
          <i class="fas fa-file-upload me-1"></i> Importar
        </template>
        <template v-else>
          <i class="fas fa-spinner fa-spin me-1"></i> Procesando datos...
        </template>
      </Button>
    </div>

    <div v-if="!loading" class="d-flex justify-content-end">
      <Link :href="route('points.index')">
        <Button type="button" class="btn-secondary" title="Salir">Salir</Button>
      </Link>
    </div>
  </form>
</template>

<script setup>
// Components
import vSelect from 'vue-select'
import { Link } from '@inertiajs/inertia-vue3'
import Button from '../../Jetstream/Button.vue'
import Label from '../../Jetstream/Label.vue'
import Input from '../../Jetstream/Input.vue'
import InputError from '../../Jetstream/InputError.vue'

// Hooks & Libraries
import PointApi from '../../Api/Point'
import { computed, ref } from 'vue'

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

const emit = defineEmits(['successImport', 'fileHasErrors', 'unexpectedError'])

const form = ref({
  category_id: null,
  subcategory_id: null,
  ecoregion_id: null,
  file: null,
})

const loading = ref(false)
const errors = ref({})
const success = ref(false)
const importFailed = ref(false)

const subcategories = computed(() => (!form.value.category_id
  ? []
  : props.categories.find(
    (category) => category.id === form.value.category_id
  ).subcategories))

const canShowSubmitButton = computed(() => {
  if (success.value) {
    return false
  }

  if (importFailed.value) {
    return false
  }

  return true
})

function removeFile () {
  form.value.file = null
}

function setFile (e) {
  if (!e.target.files[0]) {
    removeFile()
    return
  }
  const [file] = e.target.files
  form.value.file = file
}

async function submit () {
  loading.value = true
  errors.value = {}
  success.value = false

  const formData = new FormData()

  Object.entries(form.value).forEach(([key, value]) => {
    formData.append(key, value)
  })

  try {
    const res = await PointApi.storeImport(formData)
    emit('successImport', await res.data)
    success.value = true
  } catch (err) {
    const { status } = err.response

    if (status === 422) { // Form validation
      errors.value = err.response.data.errors
      return
    }

    if (status === 400) { // File has errors
      importFailed.value = true
      emit('fileHasErrors', err.response.data)
      return
    }
    // Unexpected
    emit('unexpectedError')
  } finally {
    loading.value = false
  }
}
</script>
