<template>
  <InertiaHead title="Políticas de Privacidad" />
  <div class="container-fluid">
    <div class="row justify-content-center pt-4">
      <div class="col-12">
        <div class="card shadow-sm">
          <div v-html="policy" class="card-body">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { InertiaHead } from '@inertiajs/inertia-vue3'

export default defineComponent({
  props: {
    policy: {
      type: String,
      required: true,
    },
  },

  components: {
    InertiaHead,
  },
})
</script>
