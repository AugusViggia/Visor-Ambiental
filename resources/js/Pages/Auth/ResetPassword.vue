<template>
  <InertiaHead title="Establecer nueva contraseña" />

  <div class="container top-0 position-sticky z-index-sticky">
    <div class="row">
      <div class="col-12">
        <navbar
          is-blur="blur blur-rounded my-3 py-2 start-0 end-0 mx-4 shadow"
          btn-background="bg-gradient-success"
          :dark-mode="true"
        />
      </div>
    </div>
  </div>
  <main class="mt-0 main-content main-content-bg">
    <section>
      <div class="page-header min-vh-75">
        <jet-authentication-card>
          <template #cardHeader>
            <h3 class="font-weight-bolder text-success text-gradient">
              Establecimiento de contraseña
            </h3>
            <p class="mb-0">Ingresa tu email y una nueva contraseña.</p>
          </template>
          <div>
            <jet-validation-errors class="mb-3" />

            <form @submit.prevent="submit">
              <div class="mb-3">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" v-model="form.email" required autofocus />
              </div>

              <div class="mb-3">
                <jet-label for="password" value="Contraseña" />
                <jet-input id="password" type="password" v-model="form.password" required autocomplete="new-password" />
              </div>

              <div class="mb-3">
                <jet-label for="password_confirmation" value="Repetir la contraseña" />
                <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" />
              </div>

              <div class="d-grid gap-2">
                <button
                  type="submit"
                  class="btn btn-block bg-gradient-success"
                  :class="{ 'text-white-50': form.processing }"
                  :disabled="form.processing"
                  title="Establecer contraseña"
                >
                  <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                  </div>
                  Establecer contraseña
                </button>
              </div>
            </form>
          </div>
        </jet-authentication-card>
      </div>
    </section>
  </main>
  <app-footer />
</template>

<script>
import { defineComponent } from 'vue'
import AppFooter from '@/Layouts/PageLayout/Footer'
import { InertiaHead } from '@inertiajs/inertia-vue3'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetInput from '@/Jetstream/Input'
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import Navbar from '@/Layouts/PageLayout/Navbar'
import { mapActions } from 'pinia'
import { useAppLayout } from '@/Stores/AppLayout'

export default defineComponent({
  components: {
    AppFooter,
    InertiaHead,
    JetAuthenticationCard,
    JetInput,
    JetLabel,
    JetValidationErrors,
    Navbar,
  },

  props: {
    email: String,
    token: String,
  },

  data () {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
      }),
    }
  },

  created () {
    this.toggleEveryDisplay()
  },

  beforeUnmount () {
    this.toggleEveryDisplay()
  },

  methods: {
    ...mapActions(useAppLayout, ['toggleEveryDisplay']),
    submit () {
      this.form.post(this.route('password.update'), {
        onFinish: () => this.form.reset('password', 'password_confirmation'),
      })
    },
  },
})
</script>
