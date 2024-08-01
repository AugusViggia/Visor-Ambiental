/**
 * Config for map
 */

const Config = {
  apiKey: () => process.env.MIX_MAP_ACCESS_TOKEN || '',
  defaultStyle: () => process.env.MIX_MAP_DEFAULT_STYLE ||
    'mapbox://styles/mapbox/streets-v9',
  center: () => [process.env.MIX_MAP_CENTER_LAT, process.env.MIX_MAP_CENTER_LNG] || [0, 0],
  zoom: () => process.env.MIX_MAP_ZOOM || 5,
}

export default Config
