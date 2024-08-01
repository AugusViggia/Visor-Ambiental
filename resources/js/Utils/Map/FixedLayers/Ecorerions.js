import ecoregions from '../../../../data/json/ecoregions-min.json'

const Ecoregions = {
  id: 'ecoregions',
  apply (map) {
    map.addSource(this.id, {
      type: 'geojson',
      data: ecoregions,
    })

    map.addLayer({
      id: this.id,
      type: 'fill',
      source: this.id, // reference the data source
      layout: {},
      paint: {
        'fill-color': [
          'match',
          ['get', 'id'],
          'altos-andes',
          '#b0cad9',
          'puna',
          '#45a3af',
          'yungas',
          '#f6b5d3',
          'chaco-seco',
          '#f07d00',
          'monte-de-sierras-y-bolsones',
          '#fdcd01',
          /* other */ '#ccc',
        ],
        'fill-opacity': 0.6,
      },
    })

    map.setFilter(
      this.id,
      ['any', ['==', ['get', 'id'], 0]]
    )
  },

  setFilter (map, values) {
    const filters = values.map(
      ecoregion => ['==', ['get', 'id'], ecoregion.slug]
    )

    map.setFilter(
      'ecoregions',
      ['any', ...filters]
    )
  },
}

export default Ecoregions
