<template>
  <Head title="Editar Punto Geográfico" />
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-body">
        <div class="mt-3 mb-3 d-flex justify-content-between">
          <h5 class="my-auto">Editar Punto Geográfico</h5>
        </div>
        <FormPoint
          :point="props.point"
          :errors="props.errors"
          :geometries="props.geometries"
          :categories="props.categories"
          :subcategories="props.subcategories"
          :ecoregions="props.ecoregions"
          :categoryIdDefault="props.categoryIdDefault"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import { Head } from '@inertiajs/inertia-vue3'
import FormPoint from '../../Components/Points/FormCreateUpdate.vue'

const props = defineProps({
  point: Object,
  errors: Object,
  geometries: Object,
  categories: Object,
  subcategories: Object,
  ecoregions: Object,
  categoryIdDefault: Number,
})
</script>
