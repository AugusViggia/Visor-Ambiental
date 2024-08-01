<template>
  <InertiaHead title="Forgot Password" />
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
              ¿Olvidaste tu contraseña?
            </h3>
          </template>
          <div>
            <div class="text-justify mb-2">
              No hay problema.
              Déjanos saber tu dirección de correo electrónico y te enviaremos un enlace que te permitirá elegir una nueva.
            </div>

            <div v-if="status" class="alert alert-success text-white" role="alert">
              {{ status }}
            </div>

            <jet-validation-errors class="mb-2" />

            <form @submit.prevent="submit">
              <div class="mb-3">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" v-model="form.email" required autofocus />
              </div>

              <div class="d-grid gap-2">
                <button
                  type="submit"
                  class="btn btn-block bg-gradient-success"
                  :class="{ 'text-white-50': form.processing }"
                  :disabled="form.processing"
                  title="Enviar enlace de recuperación"
                >
                  <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                  </div>
                  Enviar enlace de recuperación
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
import { InertiaHead } from '@inertiajs/inertia-vue3'
import AppFooter from '@/Layouts/PageLayout/Footer'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetInput from '@/Jetstream/Input'
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import Navbar from '@/Layouts/PageLayout/Navbar'
import { useAppLayout } from '@/Stores/AppLayout'
import { mapActions } from 'pinia'

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
    status: String,
  },

  data () {
    return {
      form: this.$inertia.form({
        email: '',
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
    ...mapActions(
      useAppLayout,
      ['toggleEveryDisplay']
    ),
    submit () {
      this.form.post(this.route('password.email'))
    },
  },
})
</script>
