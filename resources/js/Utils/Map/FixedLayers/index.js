import Ecoregions from '@/Utils/Map/FixedLayers/Ecorerions'
import Sky from '@/Utils/Map/FixedLayers/Sky'

const FixedLayers = {
  layers: [
    Ecoregions,
    Sky,
  ],

  addTo: function (map) {
    this.layers.forEach(layer => layer.apply(map))
  },

  getLayer: (id) => FixedLayers.layers.find(
    (layer) => layer.id === id
  ),
}

const layers = FixedLayers.layers

export { FixedLayers, layers }
