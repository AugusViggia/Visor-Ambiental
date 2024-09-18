<template>
  <InertiaHead title="Consulta de Categorías" />
  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12"></div>
          <div class="row">
            <div class="d-flex justify-content-between">
              <h5 class="my-auto">Consulta de Categorías</h5>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <Link
                  class="btn btn-outline-success my-auto"
                  :href="route('categories.create')"
                  title="Nueva categoría"
                >
                  <i class="fa-solid fa-tags"></i> Nueva
                </Link>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Subcategorías</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="category in categories" :key="category.id">
                  <td>{{ category.name }}</td>
                  <td>
                    <ul>
                      <li
                        v-for="subcategory in category.subcategories"
                        :key="subcategory.id"
                      >
                        {{ subcategory.name }}
                      </li>
                    </ul>
                  </td>
                  <td>
                    <Link
                      :href="`/categories/${category.id}/edit`"
                      class="btn btn-warning btn-sm me-2"
                      >Editar</Link
                    >
                    <form
                      :action="`/categories/${category.id}`"
                      method="POST"
                      style="display: inline-block"
                    >
                      <input type="hidden" name="_method" value="DELETE" />
                      <input type="hidden" name="_token" :value="csrfToken" />
                      <button type="submit" class="btn btn-danger btn-sm">
                        Eliminar
                      </button>
                    </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, InertiaHead } from '@inertiajs/inertia-vue3'

// eslint-disable-next-line no-unused-vars
const props = defineProps({
  categories: Array,
})

const csrfToken = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute('content')
</script>
