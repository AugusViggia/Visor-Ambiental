// eslint-disable-next-line import/extensions
import { markerStyles } from '@/Utils/Map/Markers'

const clusterPrefix = 'clusters'
const clusterCountPrefix = 'cluster-count'

class Clusters {
  constructor (sources, hiddeOnAdd) {
    this.sources = sources
    this.hiddeOnAdd = hiddeOnAdd || true
  }

  getClusterLayerId (code) {
    return `${clusterPrefix}-${code}`
  }

  getClusterCountLayerId (code) {
    return `${clusterCountPrefix}-${code}`
  }

  addTo (map) {
    this.sources.forEach(
      (source) => {
        const clustersLayerId = this.getClusterLayerId(source.code)
        const clusterCountLayerId = this.getClusterCountLayerId(source.code)
        const markerStyle = markerStyles.find(source.code)

        // Clusters
        map.addLayer({
          id: clustersLayerId,
          type: 'circle',
          source: source.code,
          filter: ['has', 'point_count'],
          paint: {
            // Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
            'circle-color': markerStyle.backgroundColor,
            'circle-radius': [
              'step',
              ['get', 'point_count'],
              20,
              100,
              30,
              750,
              40,
            ],
          },
        })

        // Cluster count
        map.addLayer({
          id: clusterCountLayerId,
          type: 'symbol',
          source: source.code,
          filter: ['has', 'point_count'],
          layout: {
            'text-field': '{point_count_abbreviated}',
            'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
            'text-size': 12,
          },
          paint: {
            'text-color': markerStyle.color,
          },
        })

        map.on('mouseenter', clustersLayerId, () => {
          map.getCanvas().style.cursor = 'pointer'
        })
        map.on('mouseleave', clustersLayerId, () => {
          map.getCanvas().style.cursor = ''
        })

        // inspect a cluster on click
        map.on('click', clustersLayerId, (e) => {
          const features = map.queryRenderedFeatures(e.point, {
            layers: [clustersLayerId],
          })

          const clusterId = features[0].properties.cluster_id
          map.getSource(source.code).getClusterExpansionZoom(
            clusterId,
            (err, zoom) => {
              if (err) return

              map.easeTo({
                center: features[0].geometry.coordinates,
                zoom,
              })
            }
          )
        })

        if (this.hiddeOnAdd) {
          this.hidde(clustersLayerId, map)
          this.hidde(clusterCountLayerId, map)
        }
      }
    )
  }

  hidde (source, map) {
    let sources = source
    if (!Array.isArray(sources)) {
      sources = [source]
    }
    sources.forEach((item) => {
      if (map.getLayer(item) !== undefined) {
        map.setLayoutProperty(item, 'visibility', 'none')
      }
    })
    return this
  }

  visible (source, map) {
    let sources = source
    if (!Array.isArray(sources)) {
      sources = [source]
    }
    sources.forEach((item) => {
      if (map.getLayer(item) !== undefined) {
        map.setLayoutProperty(item, 'visibility', 'visible')
      }
    })
    return this
  }

  codeToLayersId (code) {
    let codes = code
    if (!Array.isArray(codes)) {
      codes = [code]
    }

    return [
      this.getClusterLayerId(code),
      this.getClusterCountLayerId(code),
    ]
  }
}

export default Clusters
