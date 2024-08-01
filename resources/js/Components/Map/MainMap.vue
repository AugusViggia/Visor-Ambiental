<template>
  <slot></slot>
  <div class="badge bg-info text-dark mb-2 text-left" v-if="showCoordinates">
    <i class="fa-solid fa-location-dot me-2"></i>
    <span>{{ state.currentCoordinates[0] }}</span>,
    <span>{{ state.currentCoordinates[1] }}</span>
  </div>

  <div :id="mapContainer" class="map-container">
    <div v-if="loading" class="loading d-flex flex-column align-items-center">
      <span class="fa-4x text-primary">
        <i class="fa-solid fa-location-dot fa-bounce"></i>
      </span>
      <p class="text-primary">{{ $__('Loading...') }}</p>
    </div>
  </div>

  <ReportPoint ref="reportPontForm" />
</template>

<script setup>
import {
  createApp, defineComponent, nextTick, onMounted, reactive, ref, watch,
} from 'vue'
import mapboxgl from 'mapbox-gl'
import { storeToRefs } from 'pinia'
import Config from '@/Utils/Map/Config'
import { FixedLayers } from '@/Utils/Map/FixedLayers'
import { useMapStore } from '@/Stores/Map'
import Unclustered from '@/Utils/Map/Layers/Unclustered'
import Clusters from '@/Utils/Map/Layers/Clusters'
import Sources from '@/Utils/Map/Sources'
import { loadStaticLayer, StaticLayer } from '@/Utils/Map/FixedLayers/StaticLayer'
import PointPopup from '@/Components/Map/PointPopup'
import { markerStyles } from '@/Utils/Map/Markers'
import ReportPoint from '@/Components/Map/ReportPoint'

const props = defineProps({
  mapContainer: {
    type: String,
    default: 'mainMap',
  },
  showCoordinates: {
    type: Boolean,
    default: true,
  },
})

const state = reactive({
  currentCoordinates: Config.center(),
  points: null,
  groups: null,
})

const mapStore = useMapStore()

const {
  checkedEcoregions,
  checkedSubcategories,
  checkedStaticLayer,
  loading,
} = storeToRefs(mapStore)

const reportPontForm = ref(null)

onMounted(() => {
  mapboxgl.accessToken = Config.apiKey()
  const map = new mapboxgl.Map({
    container: props.mapContainer, // container ID
    style: Config.defaultStyle(), // style URL
    center: Config.center(), // starting position [lng, lat]
    zoom: Config.zoom(), // starting zoom
  })

  map.addControl(new mapboxgl.NavigationControl())

  map.on('load', () => {
    mapStore.loadPoints().then(() => {
      FixedLayers.addTo(map)

      Sources.add(mapStore.groups, map)

      // Unclustered points
      const unclustered = new Unclustered(mapStore.sourceCodes)
      unclustered.addTo(map, (payload) => {
        const coordinates = payload.geometry.coordinates.slice()
        new mapboxgl.Popup()
          .setLngLat(coordinates)
          .setHTML('<div id="popup-content"></div>')
          .addTo(map)

        const MyPopup = defineComponent({
          extends: PointPopup,
          setup () {
            const {
              id,
              altitude,
              ecoregion,
              description,
              source,
              title,
              url,
              readonly,
            } = payload.properties

            const subcategory = JSON.parse(payload.properties.subcategory)

            const removePopup = (e) => {
              const popup = document.getElementsByClassName('mapboxgl-popup')
              if (popup.length) {
                popup[0].remove()
              }
              reportPontForm.value.show(e)
            }

            const value = {
              id,
              altitude,
              ecoregion: JSON.parse(ecoregion),
              description,
              source,
              title,
              url,
              subcategory,
              iconStyle: markerStyles.find(subcategory.slug),
              readonly,
            }

            return {
              removePopup,
              value,
            }
          },
        })

        nextTick(() => {
          createApp(MyPopup).mount('#popup-content')
        })
      })

      // Clusters and Clusters Count
      const clusters = new Clusters(mapStore.sourceCodes)

      clusters.addTo(map)

      mapStore.setLoading(false)

      watch(checkedEcoregions, (newValue, oldValue) => {
        if (oldValue !== newValue) {
          FixedLayers.getLayer('ecoregions')
            .setFilter(map, newValue)

          Sources.setData(mapStore.sources, map)
        }
      })

      watch(checkedSubcategories, async (newValue, oldValue) => {
        if (oldValue !== newValue) {
          newValue.forEach(
            (value) => {
              const layers = clusters.codeToLayersId(value.slug)
              clusters.visible(layers, map)
              unclustered.visible(value.slug, map)
            }
          )
          oldValue.forEach(
            (value) => {
              const index = newValue.findIndex((item) => item.slug === value.slug)
              if (index < 0) {
                const layers = clusters.codeToLayersId(value.slug)
                clusters.hidde(layers, map)
                unclustered.hidde(value.slug, map)
              }
            }
          )
        }
      })

      watch(checkedStaticLayer, (newValue, oldValue) => {
        if (oldValue !== newValue) {
          newValue.forEach(
            (value) => {
              if (!StaticLayer.isLoaded(value, map)) {
                mapStore.setLoading(true)
                loadStaticLayer(value.id)
                  .then((content) => {
                    mapStore.setStaticLayerContent(content)
                    StaticLayer.apply({ ...value, ...content }, map)
                    map.moveLayer(value.id, 'ecoregions')
                    mapStore.setLoading(false)
                  })
              } else {
                StaticLayer.show(value, map)
              }
            }
          )

          oldValue.forEach(
            (value) => {
              const index = newValue.findIndex(({ id }) => id === value.id)
              if (index < 0) {
                StaticLayer.hidde(value, map)
              }
            }
          )
        }
      })
    })
  })

  map.on('mousemove', (e) => {
    state.currentCoordinates = e.lngLat.wrap().toArray()
  })
})
</script>

<style scoped>
#mainMap {
  background-color: #4a5568;
  position: relative;
  width: 100%;
  height: 100%;
}

#mainMap .map-style-selector {
  position: absolute;
  top: 0;
  left: 0;
}

#mainMap .loading {
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 1000;
}
</style>
