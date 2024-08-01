<template>
  <InertiaHead title="Mapa" />

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-12 map-container">
        <MainMap :show-coordinates="false"></MainMap>
      </div>
    </div>
  </div>
</template>

<script setup>
import MainMap from '../../Components/Map/MainMap'
import { InertiaHead, usePage } from '@inertiajs/inertia-vue3'
import { useMapStore } from '@/Stores/Map'
import { onMounted } from 'vue'

const mapStore = useMapStore()

onMounted(() => {
  mapStore.setCategories(usePage().props.value.categories)
  mapStore.setEcoregions(usePage().props.value.ecoregions)
  mapStore.setStaticLayers(usePage().props.value.staticLayers)
})

</script>

<style scoped>
.map-container {
  height: 82vh;
  width: 100%;
}
</style>
