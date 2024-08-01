<template>
  <Head title="Ver punto" />
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-body">
        <div class="mt-3 mb-3 d-flex justify-content-between">
          <h5 class="my-auto">Ver punto Geográfico</h5>
        </div>
        <MapShow :longitude="props.point.longitude" :latitude="props.point.latitude"/>
        <ShowPoint :point="props.point" />
        <ObservationList :point="props.point" :optionsShow="false"/>
        <DenounceShow :reason="props.point.reason" />
        <div class="d-flex justify-content-end">
          <Link class="btn btn-secondary" :href="route('points.index')" title="Volver">Volver</Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import ObservationList from '../../Components/Points/Partials/ObservationList'
import ShowPoint from '../../Components/Points/ShowPoint'
import DenounceShow from '../../Components/Points/Partials/DenounceShow'
import MapShow from '../../Components/Points/Partials/MapShow'

const props = defineProps({
  point: Object,
})

</script>
