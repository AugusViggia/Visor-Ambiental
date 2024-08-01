<template>
  <section id="denounce">
    <div class="card mb-3">
      <div class="card-body">
        <h6 class="card-text">Motivo de denuncia</h6>
        <div v-if="props.reason">
          <p class="text-center">{{ props.reason }}</p>
        </div>
        <div v-else class="alert alert-success text-white" role="alert">
          <strong>
            <i class="fas fa-info-circle"></i> No hay denuncias realizadas por el momento
          </strong>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>

const props = defineProps({
  reason: String,
})

</script>
