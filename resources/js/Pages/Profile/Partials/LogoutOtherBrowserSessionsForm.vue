<template>
  <jet-action-section>
    <template #title>
      {{ $__('Browser Sessions') }}
    </template>

    <template #description>
      {{ $__('Manage and log out your active sessions on other browsers and devices.') }}
    </template>

    <template #content>

      <jet-action-message :on="form.recentlySuccessful">
        {{ $__('Done.') }}
      </jet-action-message>

      <div>
        {{ $__('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
      </div>

      <!-- Other Browser Sessions -->
      <div class="mt-3" v-if="sessions.length > 0">
        <div class="d-flex" v-for="session in sessions" :key="session.ip_address">
          <div>
            <svg fill="none" width="32" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 viewBox="0 0 24 24" stroke="currentColor" class="text-muted" v-if="session.agent.is_desktop">
              <path
                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" width="32" viewBox="0 0 24 24" stroke-width="2"
                 stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-muted"
                 v-else>
              <path d="M0 0h24v24H0z" stroke="none"></path>
              <rect x="7" y="4" width="10" height="16" rx="1"></rect>
              <path d="M11 5h2M12 17v.01"></path>
            </svg>
          </div>

          <div class="ms-2">
            <div>
              {{ session.agent.platform ? session.agent.platform : $__('Unknown') }} -
              {{ session.agent.browser ? session.agent.browser : $__('Unknown') }}
            </div>

            <div>
              <div class="small font-weight-lighter text-muted">
                {{ session.ip_address }},

                <span class="text-success font-weight-bold" v-if="session.is_current_device">{{
                    $__('This device')
                  }}</span>
                <span v-else>Last active {{ session.last_active }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex mt-3">
        <jet-button @click="confirmLogout">
          {{ $__('Log out Other Browser Sessions') }}
        </jet-button>
      </div>

      <!-- Log out Other Devices Confirmation Modal -->
      <jet-dialog-modal id="confirmingLogoutModal">
        <template #title>
          {{ $__('Log out Other Browser Sessions') }}
        </template>

        <template #content>
          {{
            $__('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.')
          }}

          <div class="form-group mt-3 w-md-75">
            <jet-input type="password" placeholder="Password"
                       ref="password"
                       :class="{ 'is-invalid': form.errors.password }"
                       v-model="form.password"
                       @keyup.enter="logoutOtherBrowserSessions"/>

            <jet-input-error :message="form.errors.password"/>
          </div>
        </template>

        <template #footer>
          <jet-secondary-button data-dismiss="modal" @click="closeModal">
            {{ $__('Cancel') }}
          </jet-secondary-button>

          <jet-button class="ms-2" @click="logoutOtherBrowserSessions" :class="{ 'text-white-50': form.processing }"
                      :disabled="form.processing">
            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">{{ $__('Loading...') }}</span>
            </div>

            {{ $__('Log out Other Browser Sessions') }}
          </jet-button>
        </template>
      </jet-dialog-modal>
    </template>
  </jet-action-section>
</template>

<script>
import { defineComponent } from 'vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetActionSection from '@/Jetstream/ActionSection.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default defineComponent({
  props: ['sessions'],

  components: {
    JetActionMessage,
    JetActionSection,
    JetButton,
    JetDialogModal,
    JetInput,
    JetInputError,
    JetSecondaryButton,
  },

  data () {
    return {
      form: this.$inertia.form({
        password: '',
      }),
      modal: null,
    }
  },

  methods: {
    confirmLogout () {
      this.form.password = ''

      const el = document.querySelector('#confirmingLogoutModal')
      this.modal = new bootstrap.Modal(el)
      this.modal.show()

      setTimeout(() => this.$refs.password.focus(), 250)
    },

    logoutOtherBrowserSessions () {
      this.form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.password.focus(),
        onFinish: () => this.form.reset(),
      })
    },

    closeModal () {
      this.modal.hide()

      this.form.reset()
    },
  },
})
</script>
