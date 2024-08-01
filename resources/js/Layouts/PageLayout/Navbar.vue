<template>
  <!-- Navbar -->
  <nav
    class="top-0 navbar navbar-expand-lg position-absolute z-index-3"
    :class="isBlur ? isBlur : 'shadow-none my-2 navbar-transparent w-100'"
  >
    <div class="container">
      <Link
        class="navbar-brand font-weight-bolder ms-lg-0 ms-3"
        to="/dashboard"
        v-bind="$attrs"
        :class="isBlur ? 'text-dark' : 'text-white'"
      >
        {{ $page.props.application.name }}
      </Link>
      <button
        class="navbar-toggler shadow-none ms-2"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navigation"
        aria-controls="navigation"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <Link
              class="nav-link d-flex align-items-center me-2 active"
              aria-current="page"
              title="Mapa"
              :href="route('map.index')"
            >
              <i
                class="fa fa-map-location-dot opacity-6 me-1"
                aria-hidden="true"
                :class="isBlur ? 'text-dark' : 'text-white'"
              ></i>
              Mapa
            </Link>
          </li>
          <li v-if="$page.props.user" class="nav-item">
            <Link class="nav-link me-2" to="/profile">
              <i
                class="fa fa-user opacity-6 me-1"
                aria-hidden="true"
                :class="isBlur ? 'text-dark' : 'text-white'"
              ></i>
              Profile
            </Link>
          </li>
          <li v-if="!$page.props.user" class="nav-item">
            <Link class="nav-link me-2" :href="route('register')" title="Registrarse">
              <i
                class="fas fa-user-circle opacity-6 me-1"
                aria-hidden="true"
                :class="isBlur ? 'text-dark' : 'text-white'"
              ></i>
              Registrarse
            </Link>
          </li>
          <li v-if="!$page.props.user" class="nav-item">
            <Link class="nav-link me-2" :href="route('login')" title="Ingresar">
              <i
                class="fas fa-key opacity-6 me-1"
                aria-hidden="true"
                :class="isBlur ? 'text-dark' : 'text-white'"
              ></i>
              Ingresar
            </Link>
          </li>
        </ul>
        <ul class="navbar-nav d-lg-block d-none">
          <li class="nav-item">
            <Link
              :href="route('map.index')"
              class="btn btn-sm btn-round mb-0 me-1"
              :class="isBlur ? 'bg-gradient-dark' : 'bg-gradient-success'"
              title="Ir al mapa"
              >Ir al Mapa
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
  name: 'NavbarLayout',

  components: {
    // eslint-disable-next-line vue/no-reserved-component-names
    Link,
  },

  props: {
    btnBackground: String,
    isBlur: String,
    darkMode: {
      type: Boolean,
      default: false,
    },
  },

  data () {
    return {
      //
    }
  },

  computed: {
    darkModes () {
      return {
        'text-dark': this.darkMode,
      }
    },
  },
}
</script>
