<template>
  <h6>Mapa</h6>
  <img class="img-fluid"
    alt="static Mapbox map of the Visor"
    :src=getUrl
  />

</template>
<script setup>
import { computed } from 'vue'
import Config from '@/Utils/Map/Config'

const props = defineProps({
  latitude: Number,
  longitude: Number,
})

const getUrl = computed(() => {
  return `https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-l-embassy+f74e4e(${props.longitude},${props.latitude})/${props.longitude},${props.latitude},5.5/600x400?access_token=${Config.apiKey()}`
})
</script>
