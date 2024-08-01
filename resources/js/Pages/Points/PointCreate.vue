<template>
  <Head title="Alta de nuevo Punto" />
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-body">
        <h5 class="my-auto">Nuevo Punto Geográfico</h5>
        <FormPoint
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
import FormPoint from '../../Components/Points/FormCreateUpdate'

const props = defineProps({
  errors: Object,
  geometries: Object,
  categories: Object,
  subcategories: Object,
  ecoregions: Object,
  categoryIdDefault: Number,
})
</script>
