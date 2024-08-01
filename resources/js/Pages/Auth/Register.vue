<template>
  <InertiaHead title="Registro" />

  <navbar
    btn-background="bg-gradient-primary"
  />
  <div
    class="pt-5 m-3 page-header align-items-start min-vh-50 pb-11 border-radius-lg bg-option-2"
  >
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
      <div class="row justify-content-center">
        <div class="mx-auto text-center col-lg-5">
          <h1 class="mt-5 mb-2 text-white">¡Te damos la bienvenida!</h1>
          <p class="text-white text-lead">
            Completa el siguiente formulario para solicitar una cuenta.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
      <div class="mx-auto col-xl-4 col-lg-5 col-md-7">
        <div class="card z-index-0">
          <div class="card-body">
            <jet-validation-errors class="mb-3" />

            <form @submit.prevent="submit">
              <div class="mb-3">
                <jet-label for="name" value="Nombre y Apellido" />
                <jet-input id="name" type="text" v-model="form.name" required autofocus autocomplete="name" placeholder="Ingresa tu nombre y apellido"/>
              </div>

              <div class="mb-3">
                <jet-label for="document_number" value="Nro. de Documento" />
                <jet-input id="document_number" type="text" v-model="form.document_number" required autofocus autocomplete="document_number" placeholder="Sin puntos ni expacios" />
              </div>

              <div class="mb-3">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" v-model="form.email" required placeholder="ejemplo@ejemplo.com"/>
              </div>

              <div class="mb-3">
                <jet-label for="institution" value="Institución" />
                <jet-input id="institution" type="text" v-model="form.institution" required autofocus autocomplete="institution" placeholder="Ingresa el nombre de la institución" />
              </div>

              <div class="mb-3">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" v-model="form.password" required autocomplete="new-password" />
              </div>

              <div class="mb-3">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" />
              </div>

              <div class="mb-3" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <Switch
                  name="terms"
                  id="terms"
                  v-model:checked="form.terms"
                >
                  Acepto los <a class="text-primary" target="_blank" :href="route('terms.show')">Términos del Servicio</a> y las <a class="text-primary" target="_blank" :href="route('policy.show')">Políticas de Privacidad</a>
                </Switch>
              </div>

              <div class="d-grid gap-2">
                <button
                  type="submit"
                  class="btn btn-block bg-gradient-success"
                  :class="{ 'text-white-50': form.processing }"
                  :disabled="form.processing"
                  title="Registrarme"
                >
                  <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                  </div>
                  Registrarme
                </button>
              </div>
              <p class="mb-0 text-center text-sm">
                ¿Ya tienes una cuenta?<br>
                <Link
                  :href="route('login')"
                  class="text-success text-gradient font-weight-bold"
                  title="¿Ya tienes una cuenta?"
                >
                  Ingresa aquí.
                </Link>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <app-footer />
</template>

<script>
import { defineComponent } from 'vue'
import AppFooter from '@/Layouts/PageLayout/Footer'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { InertiaHead, Link } from '@inertiajs/inertia-vue3'
import Navbar from '@/Layouts/PageLayout/Navbar'
import Switch from '@/Components/Switch'
import { mapActions } from 'pinia'
import { useAppLayout } from '@/Stores/AppLayout'

export default defineComponent({
  components: {
    AppFooter,
    InertiaHead,
    JetInput,
    JetLabel,
    JetValidationErrors,
    // eslint-disable-next-line vue/no-reserved-component-names
    Link,
    Navbar,
    // eslint-disable-next-line vue/no-reserved-component-names
    Switch,
  },

  created () {
    this.toggleEveryDisplay()
  },

  beforeUnmount () {
    this.toggleEveryDisplay()
  },

  data () {
    return {
      form: this.$inertia.form({
        name: '',
        document_number: '',
        email: '',
        institution: '',
        password: '',
        password_confirmation: '',
        terms: false,
      }),
    }
  },

  methods: {
    ...mapActions(useAppLayout, ['toggleEveryDisplay']),
    submit () {
      this.form.post(this.route('register'), {
        onFinish: () => this.form.reset('password', 'password_confirmation'),
      })
    },
  },
})
</script>
