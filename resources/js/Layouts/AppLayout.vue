<template>
  <div>
    <InertiaHead :title="title" />

    <sidenav
      v-if="showSidenav"
      custom-class="card-background-mask-success"
      class="fixed-start"
      :class="isTransparent"
    ></sidenav>

    <!-- Page Content -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      <!-- nav -->
      <navbar
        :class="[navClasses]"
        :textWhite="isAbsolute ? 'text-white opacity-8' : ''"
        :minNav="navbarMinimize"
        v-if="showNavbar"
      />

      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12">
            <ActionMessage :on="hasAlert" :custom-class="alertClasses">
              {{ alertMessage }}
            </ActionMessage>
          </div>
        </div>
      </div>

      <slot></slot>

      <app-footer v-if="showFooter" class="mt-auto" />
    </main>
  </div>
</template>

<script>

import { InertiaHead } from '@inertiajs/inertia-vue3'
import Navbar from '../Components/Navbars/Navbar'
import Sidenav from '../Components/Sidenav'
import AppFooter from '../Components/Footer'
import { mapActions, mapState } from 'pinia'
import { useAppLayout } from '@/Stores/AppLayout'
import ActionMessage from '@/Jetstream/ActionMessage'

export default {
  props: {
    title: String,
  },

  components: {
    ActionMessage,
    AppFooter,
    InertiaHead,
    Navbar,
    Sidenav,
  },

  computed: {
    ...mapState(useAppLayout, [
      'isAbsolute',
      'isTransparent',
      'isNavFixed',
      'showFooter',
      'showNavbar',
      'showSidenav',
    ]),
    navClasses () {
      return {
        'position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky':
          this.isNavFixed,
        'position-absolute px-4 mx-0 w-100 z-index-2': this.isAbsolute,
        'px-0 mx-4 mt-4': !this.isAbsolute,
      }
    },
    hasAlert () {
      return this.$page.props.alert.message !== null
    },
    alertClasses () {
      if (!this.hasAlert) {
        return null
      }

      let color = ''

      switch (this.$page.props.alert.type) {
        case 'danger':
        case 'warning':
        case 'success':
          color = 'text-white'
          break
      }

      return `alert-${this.$page.props.alert.type} ${color}`
    },
    alertMessage () {
      return this.$page.props.alert.message
    },
  },
  beforeMount () {
    // @TODO set the bg-transparent class if it need to be transparent
    this.setBgTransparent()
  },
  methods: {
    ...mapActions(useAppLayout, [
      'navbarMinimize',
      'setBgTransparent',
    ]),
  },
}
</script>
