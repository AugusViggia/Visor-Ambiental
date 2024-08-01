<template>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="table-light text-black-50">
        <tr>
          <th scope="col"></th>
          <th scope="col">Nombre y Apellido</th>
          <th scope="col">Nº Documento</th>
          <th scope="col">Email</th>
          <th scope="col">Institución</th>
          <th scope="col">Rol</th>
          <th scope="col">Estado</th>
          <th scope="col">Último acceso</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in props.users" :key="user.id">
          <td>
            <Link class="p-2" title="Editar usuario" :href="route('users.edit', user.id)">
              <i class="far fa-edit"></i>
            </Link>

            <a
              @click.prevent="setUserToBlockOrEnable(user)"
              class="p-2"
              :title="user.enabled ? 'Bloquear usuario' : 'Desbloquear usuario'"
            >
              <i v-if="user.enabled" class="far fa-times-circle"></i>
              <i v-else class="far fa-check-circle"></i>
            </a>
          </td>
          <td>{{ user.name }}</td>
          <td>{{ user.document_number }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.institution }}</td>
          <td>{{ user.roles[0]?.title }}</td>
          <td>{{ user.enabled ? 'Habilitado' : 'Bloqueado' }}</td>
          <td>{{ user.last_access ? $timestampFormat(user.last_access) : null }}</td>
        </tr>
      </tbody>
    </table>
    <JetDialogModal id="blockOrEnableUserModal">
      <template #title>
          {{ userToBlockOrEnable?.enabled ? 'Bloquear' : 'Desbloquear' }}
      </template>
      <template #content>
          <div class="alert alert-warning" role="alert">
              ¿Estás seguro que deseas <strong>{{ userToBlockOrEnable?.enabled ? 'bloquear' : 'desbloquear' }}</strong> a este usuario?
          </div>
          <div>
            <strong>Apellido y Nombre: </strong> {{ userToBlockOrEnable?.name }}
          </div>
          <div>
            <strong>Email: </strong> {{ userToBlockOrEnable?.email }}
          </div>
      </template>
      <template #footer>
          <jet-button
            v-if="userToBlockOrEnable"
            :class="[userToBlockOrEnable?.enabled ? 'btn-danger' : 'btn-success']"
            title="Confirmar"
            @click.prevent="blockOrEnableUser"
            :disabled="form.processing"
          >
            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">{{ $__('Loading...') }}</span>
            </div>
            {{ $__('Confirmar') }}
          </jet-button>
          <jet-secondary-button class="btn btn-secondary" data-dismiss="modal" @click="closeModal" :title="$__('Cancel')">
            {{ $__('Cancel') }}
          </jet-secondary-button>
      </template>

    </JetDialogModal>
  </div>
</template>

<script setup>
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import JetButton from '@/Jetstream/Button.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

const props = defineProps({
  users: Object,
})

const form = useForm()

const modal = ref(null)
const userToBlockOrEnable = ref(null)

const blockOrEnableUser = () => {
  if (!userToBlockOrEnable.value) {
    return
  }
  if (form.processing) {
    return
  }
  let url = route('users.block', userToBlockOrEnable.value.id)
  if (!userToBlockOrEnable.value.enabled) {
    url = route('users.enable', userToBlockOrEnable.value.id)
  }
  form.put(url, {
    onSuccess: () => {
      closeModal()
    },
  })
}

const setUserToBlockOrEnable = (user) => {
  userToBlockOrEnable.value = user
  const el = document.querySelector('#blockOrEnableUserModal')
  modal.value = new bootstrap.Modal(el)
  modal.value.show()
}

const closeModal = () => {
  modal.value.hide()
}

</script>
