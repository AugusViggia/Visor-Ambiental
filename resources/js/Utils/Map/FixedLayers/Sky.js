const Sky = {
  id: 'sky',
  apply (map) {
    map.addLayer({
      id: this.id,
      type: this.id,
      paint: {
        'sky-type': 'atmosphere',
        'sky-atmosphere-sun': [0.0, 0.0],
        'sky-atmosphere-sun-intensity': 15,
      },
    })
  },
}

export default Sky
