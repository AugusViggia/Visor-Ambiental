<template>
  <nav
    class="shadow-none navbar navbar-main navbar-expand-lg border-radius-xl"
    v-bind="$attrs"
    id="navbarBlur"
    data-scroll="true"
  >
    <div class="px-3 py-1 container-fluid">
      <breadcrumbs :currentPage="currentRouteName" :textWhite="textWhite"/>

      <div v-if="$page.props.user" class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
        <div v-if="$page.props.application.can_search" class="ms-md-auto pe-md-3 d-flex align-items-center">
          <div class="input-group">
            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
            <input type="text" class="form-control" placeholder="Buscar ...">
          </div>
        </div>
        <ul class="navbar-nav float-end justify-content-end">

          <jet-dropdown id="manualesDropdown">
            <template #trigger>
              <span class="me-1">
                <i class="far fa-question-circle me-1 mt-2"></i>
                <i class="fas fa-chevron-down mt-2"></i>
              </span>
            </template>
            <template #content>
              <!-- Account Management -->
              <h6 class="dropdown-header small text-muted">
                Manuales de usuario
              </h6>

              <a v-role="'ADM'" target="_blank" class="dropdown-item px-4" :href="route('manuales.admin')">
                <i class="fa-regular fa-file-word me-1"></i> Del administrador
              </a>

              <hr v-role:any="'ADM|USI'"  class="dropdown-divider">

              <a target="_blank" class="dropdown-item px-4" :href="route('manuales.consulta')">
                <i class="fa-regular fa-file-word"></i> De usuario externo
              </a>
            </template>
          </jet-dropdown>
          <!-- Authentication Links -->
          <jet-dropdown id="settingsDropdown">
            <template #trigger>
              <span class="me-2">
                <img
                  v-if="$page.props.jetstream.managesProfilePhotos && $page.props.user.profile_photo_url"
                  class="rounded-circle"
                  width="32" height="32"
                  :src="$page.props.user.profile_photo_url"
                  :alt="$page.props.user.name"
                />
              </span>

              <span>
                {{ $page.props.user.name }}
                <i class="fas fa-chevron-down"></i>
              </span>
            </template>

            <template #content>
              <!-- Account Management -->
              <h6 class="dropdown-header small text-muted">
                Mi cuenta
              </h6>

              <jet-dropdown-link :href="route('profile.show')">
                Perfil
              </jet-dropdown-link>

              <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                API Tokens
              </jet-dropdown-link>

              <hr class="dropdown-divider">

              <!-- Authentication -->
              <form @submit.prevent="logout">
                <jet-dropdown-link as="button">
                  Cerrar sesión
                </jet-dropdown-link>
              </form>
            </template>
          </jet-dropdown>
        </ul>
      </div>

      <ul class="navbar-nav justify-content-end">
        <li v-if="!$page.props.user" class="nav-item d-flex align-items-center">
          <Link
            :href="route('login')"
            class="px-0 nav-link font-weight-bold"
            :class="textWhite ? textWhite : 'text-body'"
            title="Ingresar"
          >
            <i class="fa fa-user me-sm-1"></i>
            <span class="d-sm-inline d-none">Ingresar</span>
          </Link>
        </li>
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a
            href="#"
            @click.prevent="toggleSidebar"
            class="p-0 nav-link text-body"
            id="iconNavbarSidenav"
          >
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
import Breadcrumbs from '../Breadcrumbs.vue'
import { Link } from '@inertiajs/inertia-vue3'
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import { useAppLayout } from '@/Stores/AppLayout'
import { mapActions } from 'pinia'

export default {
  name: 'mapNavbar',

  components: {
    Breadcrumbs,
    JetDropdown,
    JetDropdownLink,
    // eslint-disable-next-line vue/no-reserved-component-names
    Link,
  },

  props: {
    minNav: {
      type: [Object, Function],
      default: () => null,
    },
    textWhite: {
      type: String,
      default: '',
    },
  },

  data () {
    return {
      showMenu: true,
    }
  },

  computed: {
    currentRouteName () {
      return 'Example'
    },
    isNavFixed () {
      return true
    },
  },

  created () {
    // eslint-disable-next-line no-unused-expressions
    this.minNav
  },

  updated () {
    const navbar = document.getElementById('navbarBlur')
    window.addEventListener('scroll', () => {
      if (window.scrollY > 10 && this.isNavFixed) {
        navbar.classList.add('blur')
        navbar.classList.add('position-sticky')
        navbar.classList.add('shadow-blur')
      } else {
        navbar.classList.remove('blur')
        navbar.classList.remove('position-sticky')
        navbar.classList.remove('shadow-blur')
      }
    })
  },

  methods: {
    ...mapActions(useAppLayout, ['navbarMinimize', 'toggleSidebarColor']),

    logout () {
      this.$inertia.post(route('logout'))
    },

    toggleSidebar () {
      this.toggleSidebarColor('bg-white')
      this.navbarMinimize()
    },
  },
}
</script>
