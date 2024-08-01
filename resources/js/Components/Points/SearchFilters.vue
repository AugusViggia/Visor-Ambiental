<template>
  <div id="search" class="mt-3">
    <div class="mt-3">
      <form @submit.prevent="fetch">
        <div class="row g-3">
          <div class="col-md-3">
            <jet-label for="title" value="Título" />
            <jet-input
              id="title"
              v-model="form.title"
              :class="{ 'is-invalid': props.errors.title }"
            />
            <jet-input-error :message="errors.title" />
          </div>
          <div class="col-md-3">
            <jet-label for="categoria" value="Categoría" />
            <select
              v-model="form.category_id"
              class="form-select"
              @update:modelValue="updateSubcategories(form.category_id)"
            >
              <option
                v-for="category in categories"
                :value="category.id"
                :key="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>
          <div class="col-md-3">
            <jet-label for="subCategoria" value="Subcategoría" />
            <select v-model="form.subcategory_id" class="form-select">
              <option
                v-for="subCategory in subCategoriesSelected"
                :value="subCategory.id"
                :key="subCategory.id"
              >
                {{ subCategory.name }}
              </option>
            </select>
          </div>
          <div class="col-md-3">
            <jet-label for="ecoregion" value="Ecoregión" />
            <select v-model="form.ecoregion_id" class="form-select">
              <option
                v-for="ecoregion in ecoregions"
                :value="ecoregion.id"
                :key="ecoregion.id"
              >
                {{ ecoregion.name }}
              </option>
            </select>
          </div>
          <div class="col-md-3">
            <jet-label for="status" value="Estado" />
            <select v-model="form.status_id" class="form-select">
              <option
                v-for="status in statuses"
                :value="status.id"
                :key="status.id"
              >
                {{ status.name }}
              </option>
            </select>
          </div>
          <div class="col-md-2">
            <jet-label for="date_from" value="Fecha dede" />
            <jet-input
              id="date_from"
              v-model="form.date_from"
              type="date"
              :class="{ 'is-invalid': errors.date_to }"
            />
            <jet-input-error :message="errors.date_from" />
          </div>
          <div class="col-md-2">
            <jet-label for="date_to" value="Fecha hasta" />
            <jet-input
              id="date_to"
              type="date"
              v-model="form.date_to"
              :class="{ 'is-invalid': errors.date_to }"
            />
            <jet-input-error :message="errors.date_to" />
          </div>
          <div class="col-md-3" v-role="'ADM'">
            <jet-label for="user_id" value="Usuario" />
            <VueSelect
              id="user_id"
              v-model="form.user_id"
              :options="users"
              label="name"
              :reduce="
                (option, key) => {
                  return option.id;
                }
              "
              @search="searchUsers"
            >
              <template #no-options="{}"> Sin resultados </template>
            </VueSelect>
          </div>
          <div class="col-lg-2 d-flex pt-2rem">
            <JetButton class="bg-success mt-auto text-white" title="Filtrar búsqueda"> <i class="fas fa-search"></i> </JetButton>
              <JetButton
                v-if="props.filters"
                class="btn-secondary mt-auto ms-2"
                title="Limpiar búsqueda"
                @click.prevent="clean"
              >
              <i class="fas fa-times"></i>
            </JetButton>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import { computed, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import VueSelect from 'vue-select'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetButton from '@/Jetstream/Button.vue'
import { useUsersStore } from '@/Stores/Users/Main'

const props = defineProps({
  categories: Object,
  subCategories: Object,
  ecoregions: Object,
  statuses: Object,
  filters: Object,
  errors: Object,
})

const subCategoriesSelected = ref([])
const usersStore = useUsersStore()

const users = computed(() => usersStore.users)

const form = useForm({
  title: props.filters ? props.filters.title : null,
  category_id: props.filters ? props.filters.category_id : null,
  subcategory_id: props.filters ? props.filters.subcategory_id : null,
  ecoregion_id: props.filters ? props.filters.ecoregion_id : null,
  status_id: props.filters ? props.filters.status : null,
  user_id: props.filters ? props.filters.user_id : null,
  date_from: props.filters ? props.filters.date_from : null,
  date_to: props.filters ? props.filters.date_to : null,
})

function updateSubcategories (categoryId) {
  subCategoriesSelected.value = props.subCategories.filter(
    (subCategory) => subCategory.category_id === categoryId
  )
}

const searchUsers = (query, loading) => {
  usersStore.fetch(query, loading)
}

function fetch () {
  form.get(route('points.index'), { preserveState: true })
}

function clean () {
  Inertia.get(route('points.index'), {})
}
</script>
