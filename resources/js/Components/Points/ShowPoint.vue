<template>
    <DataField
        label="Título"
        :text="props.point.title"
    />
    <DataField
        label="Institución"
        :text="props.point.institution"
    />
    <DataField
        label="Fuente"
        :text="props.point.source"
    />
    <DataField
        label="Web"
        :text="props.point.url"
    />
    <DataField
        label="Geometría"
        :text="props.point.geometry.name"
    />
    <DataField
        label="Altura"
        :text="props.point.altitude"
    />
    <div class="row mb-3">
        <div class="col-lg-4">
            <DataField
                label="Categoría"
                :text="props.point.category.name"
            />
        </div>
        <div class="col-lg-4">
            <DataField
                label="Subcategoría"
                :text="props.point.subcategory.name"
            />
        </div>
        <div class="col-lg-4">
            <DataField
                label="Ecorregión"
                :text="props.point.ecoregion.name"
            />
        </div>
    </div>
    <section id="coordenadas">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="card-text">Coordenadas</h6>
          <div class="row">
            <div class="col-lg-6">
                <DataField
                label="Latitud"
                :text="props.point.latitude"
                />
            </div>
            <div class="col-lg-6">
                <DataField
                label="Longitud"
                :text="props.point.longitude"
                />
            </div>
          </div>
        </div>
      </div>
    </section>
</template>
<script setup>
import DataField from '../Common/DataField'

const props = defineProps({
  point: Object,
})

</script>
