<template>
  <form @submit.prevent="submit" class="px-3 needs-validation" novalidate>
    <ShowPoint v-if="props.point && props.point.read_only" :point="props.point"/>
    <section v-else>
      <div class="mb-2 mt-2">
      <jet-label for="title" value="Título" />
      <jet-Input
        type="text"
        v-model="form.title"
        placeholder="Ingrese título"
        :class="{ 'is-invalid': props.errors.title }"
      />
      <jet-input-error
        v-if="props.errors.title"
        :message="props.errors.title"
      />
    </div>

    <div class="mb-2">
      <jet-label for="institution" value="Institución" />
      <jet-Input
      type="text"
        v-model="form.institution"
        placeholder="Ingrese institución"
        :class="{ 'is-invalid': props.errors.institution }"
      />
      <jet-input-error
        v-if="props.errors.institution"
        :message="props.errors.institution"
      />
    </div>

    <div class="mb-2">
      <jet-label for="source" value="Fuente" />
      <jet-Input
        type="text"
        v-model="form.source"
        placeholder="Ingrese fuente"
        :class="{ 'is-invalid': props.errors.source }"
      />
      <jet-input-error
        v-if="props.errors.source"
        :message="props.errors.source"
      />
    </div>

    <div class="mb-2">
      <jet-label for="url" value="Web" />
      <jet-Input
        type="text"
        v-model="form.url"
        placeholder="Ingrese web"
        :class="{ 'is-invalid': props.errors.url }"
      />
      <jet-input-error v-if="props.errors.url" :message="props.errors.url" />
    </div>

    <div class="mb-2">
      <jet-label for="geometry_id" value="Geometría" />
      <jet-select-input id="tipo"
        v-model="form.geometry_id"
        :error="props.errors.geometry_id"
      >
        <option
          v-for="geometry in geometries"
          :key="geometry.id"
          :value="geometry.id"
        >
          {{ geometry.name }}
        </option>
      </jet-select-input>
      <jet-input-error
        v-if="props.errors.geometry_id"
        :message="props.errors.geometry_id"
      />
    </div>

    <div class="mb-2">
      <jet-label for="altitude" value="Altura" />
      <jet-Input
        type="number"
        v-model="form.altitude"
        placeholder="Ingrese altura"
        :class="{ 'is-invalid': props.errors.altitude }"
      />
      <jet-input-error
        v-if="props.errors.altitude"
        :message="props.errors.altitude"
      />
    </div>

    <div class="row mb-2">
      <div class="col-lg-4">
        <jet-label for="category_id" value="Categoria" />
        <jet-select-input id="category_id"
          v-model="form.category_id"
          :error="props.errors.category_id"
          @update:modelValue="updateSubcategories(form.category_id)"
        >
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </jet-select-input>
        <jet-input-error
          v-if="props.errors.category_id"
          :message="props.errors.category_id"
        />
      </div>
      <div class="col-lg-4">
        <jet-label for="subcategory_id" value="Subcategoria" />
        <jet-select-input id="subcategory_id"
          v-model="form.subcategory_id"
          :error="props.errors.subcategory_id"
        >
          <option
            v-for="subcategory in subCategoriesSelected"
            :key="subcategory.id"
            :value="subcategory.id"
          >
            {{ subcategory.name }}
          </option>
        </jet-select-input>
        <jet-input-error
          v-if="props.errors.subcategory_id"
          :message="props.errors.subcategory_id"
        />
      </div>
      <div class="col-lg-4">
        <jet-label for="ecoregion_id" value="Ecorregión" />
        <jet-select-input id="ecoregion_id"
          v-model="form.ecoregion_id"
          :error="props.errors.ecoregion_id"
        >
          <option
            v-for="ecoregion in ecoregions"
            :key="ecoregion.id"
            :value="ecoregion.id"
          >
            {{ ecoregion.name }}
          </option>
        </jet-select-input>
        <jet-input-error
          v-if="props.errors.ecoregion_id"
          :message="props.errors.ecoregion_id"
        />
      </div>
    </div>
    <section id="coordenadas">
      <div class="card mb-2">
        <div class="card-body">
          <h6 class="card-text">Coordenadas</h6>
          <div class="row">
            <div class="col-lg-6">
              <jet-label for="latitude" value="Latitud" />
              <jet-Input
                v-model="form.latitude"
                placeholder="Ingrese la latitud"
                :class="{ 'is-invalid': props.errors.latitude }"
              />
              <jet-input-error
                v-if="props.errors.latitude"
                :message="props.errors.latitude"
              />
            </div>
            <div class="col-lg-6">
              <jet-label for="longitude" value="Longitud" />
              <jet-Input
                v-model="form.longitude"
                placeholder="Ingrese la longitud"
                :class="{ 'is-invalid': props.errors.longitude }"
              />
              <jet-input-error
                v-if="props.errors.longitude"
                :message="props.errors.longitude"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
    </section>
    <section id="avistamiento">
      <div class="card mb-2">
        <div class="card-body">
          <div
            class="alert alert-danger text-white"
            role="alert"
            v-if="props.errors.observations"
          >
            <strong>{{ props.errors.observations }}</strong>
          </div>
          <ModalCreate :errors="props.errors" @success="addObservation" :sizeObservations="observations.length" :point="props.point"/>
          <ShowTable :observations="observations" :point="props.point" @delete="deleteObservation" :optionsShow="true"/>
        </div>
      </div>
    </section>
    <div class="d-flex justify-content-end">
      <button
      type="submit"
      :class="['btn btn-block bg-success me-2', form.processing ? 'text-white-50':'text-white']"
      :disabled="form.processing"
    >
      Guardar
    </button>
    <Link :href="route('points.index')" class="btn btn-secondary">Cancelar</Link>
    </div>
  </form>
</template>
<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3'
import JetLabel from '@/Jetstream/Label'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetSelectInput from '@/Jetstream/SelectInput'
import ModalCreate from '../../Components/Observations/ModalCreate'
import ShowTable from '../../Components/Observations/ShowTable'
import { onMounted, ref } from 'vue'
import ShowPoint from './ShowPoint'
const observations = ref([])
const props = defineProps({
  point: Object,
  geometries: Object,
  categories: Object,
  subcategories: Object,
  ecoregions: Object,
  errors: Object,
  categoryIdDefault: Number,
})

const subCategoriesSelected = ref([])

onMounted(() => {
  observations.value = props.point ? props.point.observations : []
  updateSubcategories(props.categoryIdDefault)
})

function addObservation (observation) {
  if (Object.values(observation).find(prop => prop != null)) {
    observations.value.push(observation)
  }
}

const form = useForm({
  title: props.point ? props.point.title : null,
  institution: props.point ? props.point.institution : null,
  source: props.point ? props.point.source : null,
  url: props.point ? props.point.url : null,
  geometry_id: props.point ? props.point.geometry.id : null,
  category_id: props.point ? props.point.category.id : props.categoryIdDefault,
  subcategory_id: props.point ? props.point.subcategory.id : null,
  ecoregion_id: props.point ? props.point.ecoregion.id : null,
  altitude: props.point ? props.point.altitude : null,
  latitude: props.point ? props.point.latitude : null,
  longitude: props.point ? props.point.longitude : null,
  observations: [],
})

function updateSubcategories (categoryId) {
  subCategoriesSelected.value = props.subcategories.filter(
    (subcategory) => parseInt(subcategory.category_id) === parseInt(categoryId)
  )
}

function deleteObservation (index) {
  if (index > -1) {
    observations.value.splice(index, 1)
  }
}

function submit () {
  if (!props.point) {
    form.observations = observations.value
    return form.post(route('points.store'))
  }
  return form.patch(route('points.update', { point: props.point }))
}

defineExpose({
  submit,
})
</script>
