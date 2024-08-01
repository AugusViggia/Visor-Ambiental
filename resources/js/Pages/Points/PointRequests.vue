<template>
  <InertiaHead title="Consulta de Puntos" />
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12"></div>
          <div class="row">
            <div class="d-flex justify-content-between">
              <h5 class="my-auto">Consulta de puntos</h5>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <Link
                  class="btn btn-outline-success my-auto me-md-2"
                  :href="route('points.create')"
                  title="Nuevo punto"
                >
                  <i class="fa-solid fa-location-dot"></i> Nuevo
                </Link>
                <Link
                  class="btn btn-outline-success my-auto"
                  :href="route('points.importacion.index')"
                  title="Importar excel"
                >
                  <i class="fa-solid fa-file-excel"></i> Importar excel
                </Link>
              </div>
            </div>
          </div>
          <div class="row">
            <SearchFilters
              :errors="errors"
              :filters="filters"
              :categories="categories"
              :subCategories="subCategories"
              :ecoregions="ecoregions"
              :statuses="statuses"
            />
          </div>
          <div class="row">
            <div class="d-flex justify-content-end">
              <a
                v-role="'ADM'"
                class="btn btn-outline-success my-auto"
                :href="
                  route('points.generateExcel', { filters: props.filters })
                "
                title="Generar Excel"
              >
                <i class="fa-solid fa-file-excel"></i> Generar Excel
              </a>
            </div>
          </div>
          <div class="row my-3">
            <div
              class="
                col-lg-12
                d-flex
                justify-content-end
                align-items-end
                border-bottom
              "
            >
              <StatsView :points="props.points.data" />
            </div>
          </div>
          <ListView
            v-if="props.points.data.length > 0"
            :points="props.points"
            :pointStatusList="props.pointStatusList"
          >
          </ListView>
          <ActionMessage
            :on="props.points.data.length === 0"
            custom-class="alert-sucess text-white"
          >
            {{ $__("No results.") }}
          </ActionMessage>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, InertiaHead } from '@inertiajs/inertia-vue3'
import SearchFilters from '../../Components/Points/SearchFilters'
import ListView from '../../Components/Points/ListView'
import StatsView from '../../Components/Points/StatsView'
import ActionMessage from '../../Jetstream/ActionMessage'

const props = defineProps({
  points: Object,
  categories: Object,
  subCategories: Object,
  ecoregions: Object,
  statuses: Object,
  filters: {
    type: Object,
    default: null,
  },
  errors: Object,
  pointStatusList: {
    type: Object,
    default: null,
  },
})
</script>
