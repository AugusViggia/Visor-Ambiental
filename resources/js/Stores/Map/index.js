import { defineStore } from 'pinia'
import Point from '@/Api/Point'
import { markerStyles } from '@/Utils/Map/Markers'

const compoundCategories = (categories) => {
  categories.forEach((category) => {
    category.subcategories = category.subcategories.map((subcategory) => {
      const color = markerStyles.find(subcategory.slug)
      return { ...subcategory, ...color }
    })
  })
  return categories
}

export const useMapStore = defineStore(
  'mapStore',
  {
    state: () => {
      return {
        categories: [],
        checkedEcoregions: [],
        checkedStaticLayer: [],
        checkedSubcategories: [],
        ecoregions: [],
        groups: [],
        loading: true,
        points: [],
        staticLayers: [],
      }
    },

    getters: {
      sourceCodes: (state) => state.groups.map(({ id, code }) => ({ id, code })),
      sources: (state) => {
        if (state.checkedEcoregions.length === 0) {
          return state.groups
        }

        const filtered = state.groups.map(
          (group) => {
            const features = group.features.filter(
              (item) => state.checkedEcoregions.some(
                (element) => element.id === item.properties.ecoregion_id
              )
            )

            return { ...group, ...{ features } }
          }
        )
        return filtered
      },
    },

    actions: {
      async loadPoints () {
        const response = await Point.get()
        const { data } = response
        this.points = data

        this.groups = _.map(
          _.groupBy(
            this.points.features,
            (item) => item.properties.subcategory_id
          ),
          (item) => ({
            id: item[0].properties.subcategory_id,
            code: item[0].properties.marker_code,
            type: 'FeatureCollection',
            features: item,
          })
        )
      },

      setCategories (data) {
        const icons = JSON.parse(process.env.MIX_CATEGORIES_ICONS || '[{"id": 0,"code": "map-pin"}]')

        this.categories = data.map(category => {
          const icon = icons.find(icon => icon.id === category.id) || icons[0]
          return {
            ...category,
            icon,
          }
        })

        this.categories = compoundCategories(this.categories)
      },

      setEcoregions (data) {
        this.ecoregions = data
      },

      setLoading (data) {
        this.loading = data
      },

      setStaticLayers (data) {
        this.staticLayers = data
      },

      setStaticLayerContent (data) {
        const index = this.staticLayers.findIndex((item) => item.id === data.id)
        if (index >= 0) {
          this.staticLayers[index].content = data
        }
      },

      setSelectedCategoryId ({ target }) {
        this.selectedCategoryId = target.value
      },

      setSelectedSubCategoryId ({ target }) {
        this.selectedSubCategoryId = target.value
      },

      setSelectedFixedLayerId (payload) {
        this.selectedFixedLayerId = payload
      },
    },
  }
)
