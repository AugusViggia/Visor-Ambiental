<template>

  <form @submit.prevent="handleForm">

    <div class="mb-2">
      <JetLabel>Nombre y apellido</JetLabel>
      <JetInput
        v-model="form.name"
        placeholder="Ingrese nombre y apellido"
        :class="{ 'is-invalid': form.errors.hasOwnProperty('name') }"
      />
      <InputError
          v-if="form.errors.hasOwnProperty('name')"
          :message="form.errors.name"
      ></InputError>
    </div>

    <div class="mb-2">
      <JetLabel>Nro de documento</JetLabel>
      <JetInput
        v-model="form.document_number"
        type="number"
        placeholder="Sin puntos ni espacios"
        :class="{ 'is-invalid': form.errors.hasOwnProperty('document_number') }"
      />
      <InputError
          v-if="form.errors.hasOwnProperty('document_number')"
          :message="form.errors.document_number"
      ></InputError>
    </div>

    <div class="mb-2">
      <JetLabel>Email</JetLabel>
        <JetInput
          v-model="form.email"
          type="email"
          placeholder="ejemplo@ejemplo.com"
          :class="{ 'is-invalid': form.errors.hasOwnProperty('email') }"
        />
        <InputError
            v-if="form.errors.hasOwnProperty('email')"
            :message="form.errors.email"
        ></InputError>
    </div>

    <div class="mb-2">
      <JetLabel>Institución</JetLabel>
      <JetInput
        v-model="form.institution"
        placeholder="Ingrese nombre de la institución"
        :class="{ 'is-invalid': form.errors.hasOwnProperty('institution') }"
      />
      <InputError
          v-if="form.errors.hasOwnProperty('institution')"
          :message="form.errors.institution"
      ></InputError>
    </div>

    <div class="mb-2">
    <JetLabel>Rol</JetLabel>
      <vSelect
        v-model="form.role_id"
        :options="props.roles"
        :reduce="(role) => role.id"
        label="title"
        :class="{ 'is-invalid': form.errors.hasOwnProperty('role_id') }"
      />
      <InputError
          v-if="form.errors.hasOwnProperty('role_id')"
          :message="form.errors.role_id"
      ></InputError>
    </div>

    <div class="d-flex justify-content-end mt-4">
      <JetButton
        type="submit"
        :disabled="form.processing"
        :class="['btn btn-block bg-success me-2', form.processing ? 'text-white-50':'text-white']"
        :title="props.user ? 'Actualizar datos del usuario' : 'Dar de alta del usuario'"
      >
        {{ props.user ? 'Actualizar' : 'Guardar' }}
      </JetButton>
      <Link :href="route('users.index')" class="btn btn-secondary ms-2" :disabled="form.processing" title="Cancelar">
        Cancelar
      </Link>
    </div>

  </form>

</template>

<script setup>
import { useForm, Link } from '@inertiajs/inertia-vue3'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import InputError from '@/Jetstream/InputError.vue'
import JetButton from '@/Jetstream/Button.vue'
import vSelect from 'vue-select'

const props = defineProps({
  roles: Object,
  user: {
    type: Object,
    default: null,
  },
})

const form = useForm({
  name: props.user ? props.user.name : '',
  document_number: props.user ? props.user.document_number : '',
  email: props.user ? props.user.email : '',
  institution: props.user ? props.user.institution : '',
  role_id: props.user ? props.user.roles[0].id : '',
})

const storeUser = () => {
  form.post(route('users.store'))
}

const updateUser = () => {
  form.put(route('users.update', { user: props.user.id }))
}

const handleForm = () => {
  if (!props.user) {
    storeUser()
    return
  }

  updateUser()
}

</script>
