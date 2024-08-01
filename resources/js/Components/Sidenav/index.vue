<template>
  <aside
    class="my-3 overflow-auto border-0 sidenav navbar navbar-vertical navbar-expand-xs border-radius-xl ms-3"
    id="sidenav-main"
  >
    <div class="sidenav-header position-relative">

      <button
        v-if="!isPinned"
        type="button"
        class="position-absolute top-50 end-5 translate-middle btn-close btn-close-white btn-sm"
        aria-label="Cerrar"
        @click.prevent="navbarMinimize"
      >
      </button>

      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>

      <a class="m-0 navbar-brand" href="/" :title="appName">
        <img :src="logo" class="navbar-brand-img h-100" alt="main_logo" />
        <span class="ms-1 font-weight-bold">{{ appName }}</span>
      </a>
    </div>
    <hr class="mt-0 horizontal dark" />
    <sidenav-list :cardBg="customClass" />
  </aside>
</template>
<script>
import SidenavList from './SidenavList.vue'
import { mapActions, mapState } from 'pinia'
import { useAppLayout } from '@/Stores/AppLayout'

export default {
  name: 'SindenavIndex',
  components: {
    SidenavList,
  },
  data () {
    return {
      //
    }
  },
  props: {
    customClass: {
      type: String,
      default: '',
    },
  },
  computed: {
    ...mapState(useAppLayout, ['isPinned']),
    logo () {
      return this.$page.props.application.app_logo
    },

    appName () {
      return this.$page.props.application.name
    },
  },
  methods: {
    ...mapActions(useAppLayout, ['navbarMinimize']),
  },
}
</script>
