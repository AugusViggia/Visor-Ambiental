<template>
  <div class="search">
    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <JetLabel>Nombre y Apellido</JetLabel>
          <JetInput
            id="name"
            type="text"
            v-model="form.name"
            :class="{ 'is-invalid': form.errors.name }"
          >
            <JetInputError :message="form.errors.name"/>
          </JetInput>
        </div>
        <div class="col-md-3 col-sm-12">
          <JetLabel>Nro. de documento</JetLabel>
          <JetInput
            id="document_number"
            type="text"
            v-model="form.document_number"
            :class="{ 'is-invalid': form.errors.document_number }"
          >
            <JetInputError :message="form.errors.document_number"/>
          </JetInput>
        </div>
        <div class="col-auto pt-2rem">
          <button type="submit" class="btn btn-success" title="Buscar">
            <i class="fas fa-search"></i>
          </button>
          <Link
            v-if="hasFilters"
            :href="clearUrl"
            class="btn btn-secondary ms-1"
            title="Limpiar búsqueda"
          >
            <i class="fas fa-times"></i>
          </Link>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import JetLabel from '@/Jetstream/Label'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import { computed } from 'vue'

// eslint-disable-next-line no-unused-vars,no-undef
const props = defineProps(
  {
    clearUrl: {
      type: String,
      default: null,
    },
    filters: {
      type: Object,
      default: () => null,
    },
  }
)

const hasFilters = computed(() => {
  return props.filters && (props.filters.name || props.filters.document_number)
})

const form = useForm({
  name: props.filters ? props.filters.name : null,
  document_number: props.filters ? props.filters.document_number : null,
  type: props.filters ? props.filters.type : null,
})

function submit () {
  form.get(
    // eslint-disable-next-line no-undef
    route('userRequests.index'),
    {
      preserveState: true,
      preserveScroll: true,
    }
  )
}
</script>
