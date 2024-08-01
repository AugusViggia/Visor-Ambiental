import StaticLayers from '@/Api/StaticLayers'

const loadStaticLayer = async (id) => {
  try {
    const { data } = await StaticLayers.get(id)
    return data
  } catch (error) {
    // @TODO manage the exception
    return null
  }
}

const StaticLayer = {
  apply: (source, map) => {
    map.addSource(source.id, {
      type: 'geojson',
      data: source.content,
    })

    map.addLayer({
      id: source.id,
      type: 'line',
      source: source.id,
      paint: {
        'line-color': source.color,
      },
    })
  },

  isLoaded: (source, map) => map.getSource(source.id) !== undefined,

  isVisible: (source, map) => map.getLayoutProperty(
    source.id,
    'visibility'
  ) === 'visible',

  hidde: (source, map) => map.setLayoutProperty(source.id, 'visibility', 'none'),

  show: (source, map) => map.setLayoutProperty(source.id, 'visibility', 'visible'),
}

export { loadStaticLayer, StaticLayer }
