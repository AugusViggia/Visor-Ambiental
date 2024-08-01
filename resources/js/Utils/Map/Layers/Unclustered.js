/**
 * Unclustered.js
 */
import { defaultMarkerIcon, markersIcons } from '@/Utils/Map/Markers'

const layerIdPrefix = 'unclustered-point'

const MissingImagesManager = {
  load: (map) => {
    map.on('styleimagemissing', (e) => {
      const { id } = e
      const img = new Image(36, 48)

      const markerIcon = markersIcons.filter(
        (icon) => icon.code === id
      ).shift() || defaultMarkerIcon

      img.setAttribute('src', markerIcon.icon)
      img.addEventListener(
        'load',
        () => ((!map.hasImage(id)) ? map.addImage(id, img) : false)
      )
    })
  },
}

const reolveLayerId = (source, ref) => (source.startsWith(layerIdPrefix)
  ? source
  : ref.getLayerId(source))

class Unclustered {
  constructor (sources, hiddeOnAdd) {
    this.sources = sources
    this.hiddeOnAdd = hiddeOnAdd || true
  }

  getLayerId (code) {
    return `${layerIdPrefix}-${code}`
  }

  addTo (map, popupCallback = () => {
  }) {
    MissingImagesManager.load(map)

    this.sources.forEach((source) => {
      const unclusteredLayerId = this.getLayerId(source.code)

      map.addLayer({
        id: unclusteredLayerId,
        type: 'symbol',
        source: source.code,
        filter: [
          'any',
          ['!', ['has', 'point_count']],
        ],
        layout: {
          'icon-image': ['concat', ['get', 'marker_code']],
          'icon-allow-overlap': true,
        },
      })

      // When a click event occurs on a feature in
      // the unclustered-point layer, open a popup at
      // the location of the feature, with
      // description HTML from its properties.
      map.on('click', unclusteredLayerId, (e) => {
        const coordinates = e.features[0].geometry.coordinates.slice()

        popupCallback(e.features[0])

        map.flyTo({
          center: coordinates,
          zoom: 11,
        })
      })

      map.on('mouseenter', unclusteredLayerId, () => {
        map.getCanvas().style.cursor = 'pointer'
      })

      map.on('mouseleave', unclusteredLayerId, () => {
        map.getCanvas().style.cursor = ''
      })

      if (this.hiddeOnAdd) {
        this.hidde(unclusteredLayerId, map)
      }
    })
  }

  hidde (source, map) {
    const layer = reolveLayerId(source, this)
    if (map.getLayer(layer) !== undefined) {
      map.setLayoutProperty(layer, 'visibility', 'none')
    }
  }

  visible (source, map) {
    const layer = reolveLayerId(source, this)
    if (map.getLayer(layer) !== undefined) {
      map.setLayoutProperty(layer, 'visibility', 'visible')
    }
  }
}

export default Unclustered
