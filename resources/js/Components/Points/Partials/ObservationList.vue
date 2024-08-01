<template>
  <div class="card mb-3">
    <div class="card-body">
      <h6 class="card-text">Avistamientos</h6>
      <div
        v-if="!props.point.observations.length"
        class="alert alert-success text-white"
        role="alert"
      >
        <strong> <i class="fas fa-info-circle"></i> El punto no posee avistamientos</strong>
      </div>
      <template v-else>
        <ShowTable
          :observations="props.point.observations"
          :point="props.point"
          :rejecting="true"
          :optionsShow="props.optionsShow"
        />
      </template>
    </div>
  </div>
</template>

<script setup>
import ShowTable from '@/Components/Observations/ShowTable'

const props = defineProps({
  point: Object,
  optionsShow: Boolean,
})
</script>
