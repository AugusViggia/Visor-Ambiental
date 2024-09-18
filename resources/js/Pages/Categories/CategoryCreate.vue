<template>
  <InertiaHead title="Nueva categoría" />
  <div class="card">
    <div class="card-body">
      <h5>Nueva Categoría</h5>
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label for="name" class="form-label">Nombre de la Categoría</label>
          <input type="text" v-model="form.name" class="form-control" id="name" required />
        </div>
        <div class="mb-3">
          <h6>Subcategorías</h6>
          <div v-for="(subcategory, index) in form.subcategories" :key="index" class="d-flex mb-2">
            <input
              type="text"
              v-model="subcategory.name"
              class="form-control me-2"
              placeholder="Nombre de la Subcategoría"
            />
            <button type="button" class="btn btn-outline-danger btn-sm" @click="removeSubcategory(index)">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <button type="button" class="btn btn-outline-primary btn-sm" @click="addSubcategory">
            <i class="fas fa-plus"></i> Añadir Subcategoría
          </button>
        </div>
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <Link href="/categories" class="btn btn-secondary ms-2">Cancelar</Link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
// eslint-disable-next-line no-unused-vars
import { Head, useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
  name: '',
  subcategories: [],
})

function addSubcategory () {
  form.subcategories.push({ name: '' })
}

function removeSubcategory (index) {
  form.subcategories.splice(index, 1)
}

function submit () {
  form.post('/categories')
}
</script>
