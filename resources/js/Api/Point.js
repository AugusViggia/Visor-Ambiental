const Point = {
  get: () => axios.get(route('api.points.geojson')),

  storeImport: async (payload) => axios.post(
    route('api.points.import'),
    payload,
    {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    }
  ),
}

export default Point
