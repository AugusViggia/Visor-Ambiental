<template>
  <InertiaHead title="Ingresar" />

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
              ¡Te damos la bienvenida!
            </h3>
            <p class="mb-0">Ingresa tu email y contraseña para ingresar.</p>
          </template>
          <jet-validation-errors class="mb-3" />

          <div v-if="status" class="alert alert-success mb-3 rounded-0" role="alert">
            {{ status }}
          </div>

          <form @submit.prevent="submit">
            <div class="mb-3">
              <jet-label for="email" value="Email" />
              <jet-input id="email" type="email" v-model="form.email" required autofocus />
            </div>

            <div class="mb-3">
              <jet-label for="password" value="Password" />
              <jet-input id="password" type="password" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="mb-3">
              <Switch
                id="remember_me"
                name="remember"
                v-model:checked="form.remember"
              >
                <strong>Recordarme</strong>
              </Switch>
            </div>

            <div class="d-grid gap-2">
              <button
                type="submit"
                class="btn btn-block bg-gradient-success"
                :class="{ 'text-white-50': form.processing }"
                :disabled="form.processing"
                title="Ingresar"
              >
                <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                  <span class="visually-hidden">Cargando...</span>
                </div>
                Ingresar
              </button>
            </div>

            <div class="px-1 pt-0 text-center px-lg-2">
              <p class="mx-auto mb-0 text-sm">
                ¿Olvidaste tu contraseña?<br>
                <Link
                  v-if="canResetPassword"
                  :href="route('password.request')"
                  class="text-success text-gradient font-weight-bold"
                  title="Recuperar tu contraseña"
                >
                  Recuperala aquí.
                </Link>
              </p>
            </div>
          </form>
        </jet-authentication-card>
      </div>
    </section>
  </main>
  <app-footer />
</template>

<script>
import { defineComponent } from 'vue'
import AppFooter from '@/Layouts/PageLayout/Footer'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
import JetInput from '@/Jetstream/Input'
import JetLabel from '@/Jetstream/Label'
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import { InertiaHead, Link } from '@inertiajs/inertia-vue3'
import Navbar from '@/Layouts/PageLayout/Navbar'
import Switch from '@/Components/Switch'
import { useAppLayout } from '@/Stores/AppLayout'
import { mapActions } from 'pinia'
const body = document.getElementsByTagName('body')[0]

export default defineComponent({
  components: {
    AppFooter,
    InertiaHead,
    JetAuthenticationCard,
    JetInput,
    JetLabel,
    JetValidationErrors,
    // eslint-disable-next-line vue/no-reserved-component-names
    Link,
    Navbar,
    // eslint-disable-next-line vue/no-reserved-component-names
    Switch,
  },

  props: {
    canResetPassword: Boolean,
    status: String,
  },

  created () {
    this.toggleEveryDisplay()
    body.classList.remove('bg-gray-100')
  },

  beforeUnmount () {
    this.toggleEveryDisplay()
    body.classList.add('bg-gray-100')
  },

  data () {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false,
      }),
    }
  },

  methods: {
    ...mapActions(
      useAppLayout,
      ['toggleEveryDisplay']
    ),
    submit () {
      this.form
        .transform(data => ({
          ...data,
          remember: this.form.remember ? 'on' : '',
        }))
        .post(this.route('login'), {
          onSuccess: () => window.location.reload(),
          onFinish: () => this.form.reset('password'),
        })
    },
  },
})
</script>
