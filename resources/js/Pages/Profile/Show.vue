<template>
  <InertiaHead title="Perfil" />

  <div class="container-fluid mt-4">

    <ActionMessage :on="!$page.props.user.approved_at" custom-class="alert-warning text-white">
      <div>
        <h5 class="text-white">¡Atención!</h5>
        Para acceder a las funcionalidades del Sistema, tu cuenta de usuario debe estar aprobada por el Administrador.
      </div>
    </ActionMessage>

    <div v-if="$page.props.jetstream.canUpdateProfileInformation">
      <update-profile-information-form :user="$page.props.user" />

      <jet-section-border />
    </div>

    <div v-if="$page.props.jetstream.canUpdatePassword">
      <update-password-form />

      <jet-section-border />
    </div>

    <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
      <two-factor-authentication-form />

      <jet-section-border />
    </div>

    <logout-other-browser-sessions-form :sessions="sessions" />

    <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
      <jet-section-border />

      <delete-user-form />
    </template>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue'
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue'
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'
import { InertiaHead } from '@inertiajs/inertia-vue3'
import ActionMessage from '@/Jetstream/ActionMessage'

export default defineComponent({
  props: {
    sessions: {
      type: [Array, Object],
      required: true,
    },
  },

  components: {
    ActionMessage,
    DeleteUserForm,
    InertiaHead,
    JetSectionBorder,
    LogoutOtherBrowserSessionsForm,
    TwoFactorAuthenticationForm,
    UpdatePasswordForm,
    UpdateProfileInformationForm,
  },
})
</script>
