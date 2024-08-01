const Sources = {
  options: {
    type: 'geojson',
    cluster: true,
    clusterMaxZoom: 14,
    clusterRadius: 50,
  },
  add (sources, map) {
    const options = this.options
    sources.forEach(source => {
      map.addSource(
        source.code || 'points',
        {
          ...options, ...{ data: source },
        })
    })
  },

  setData (sources, map) {
    sources.forEach(source => {
      map.getSource(source.code || 'points').setData(source)
    })
  },
}

export default Sources
