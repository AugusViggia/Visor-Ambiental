const StaticLayer = {
  fetch: () => axios.get(route('api.static.layers')),
  get: (id) => axios.get(route('api.static.layers.show'), { params: { id, load: 1 } }),
}

export default StaticLayer
