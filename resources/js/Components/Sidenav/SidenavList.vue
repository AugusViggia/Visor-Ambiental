<template>
  <div
    class="w-auto h-auto collapse navbar-collapse max-height-vh-100 h-100"
    id="sidenav-collapse-main"
  >
    <ul class="navbar-nav">
      <li class="nav-item">
        <h6 class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6 ms-2">
          Navegación
        </h6>
      </li>
      <li class="nav-item">
        <sidenav-collapse navText="Mapa" :to="{ name: 'Map', 'route': route('map.index') }">
          <template #icon="{ isActive }">
            <i class="icon-size fa-solid fa-map-location mb-1" :class="[isActive ? 'text-white' : 'text-dark']"></i>
          </template>
        </sidenav-collapse>
      </li>
    </ul>

    <FilterList v-if="showMapFilters" />

    <ul v-if="$page.props.user" class="navbar-nav">
      <li class="nav-item mt-3">
        <h6 class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6 ms-2">
          Gestión
        </h6>
      </li>

      <li class="nav-item">
        <sidenav-collapse
          nav-text="Puntos"
          :to="{ name: 'Points', route: route('points.index') }"
        >
          <template #icon="{ isActive }">
            <i class="icon-size mb-1 fa-solid fa-location-dot" :class="[isActive ? 'text-white' : 'text-dark']"></i>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item mt-3" v-role="'ADM'">
        <h6 class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6 ms-2">
          Administración
        </h6>
      </li>

      <li class="nav-item" v-permission="'users.list'">
        <sidenav-collapse
          nav-text="Categorías"
          :to="{ name: 'Categories', route: route('categories.index') }"
        >
          <template #icon="{ isActive }">
            <i class="icon-size mb-1 fa-solid fa-tags" :class="[isActive ? 'text-white' : 'text-dark']"></i>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item" v-permission="'users.list'">
        <sidenav-collapse
          nav-text="Usuarios"
          :to="{ name: 'Users', route: route('users.index') }"
        >
          <template #icon="{ isActive }">
            <i class="icon-size mb-1 fa-solid fa-users" :class="[isActive ? 'text-white' : 'text-dark']"></i>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item" v-can="'users.requestsList'">
        <sidenav-collapse
          nav-text="Solicitudes"
          :to="{ name: 'Admin/UserRequests', route: route('userRequests.index', {type: 'pending'}) }"
        >
          <template #icon="{ isActive }">
            <i class="icon-size mb-1 fa-solid fa-id-card" :class="[isActive ? 'text-white' : 'text-dark']"></i>
          </template>
        </sidenav-collapse>
      </li>

    </ul>
  </div>
  <div v-if="false" class="pt-3 mx-3 mt-3 sidenav-footer">
    <sidenav-card
      :class="cardBg"
      textPrimary="Need Help?"
      textSecondary="Please check our docs"
      route="https://www.creative-tim.com/learning-lab/vue/overview/soft-ui-dashboard/"
      label="Documentation"
      icon="ni ni-diamond"
    />
    <a
      class="btn bg-gradient-success mt-4 w-100"
      href="https://www.creative-tim.com/product/vue-soft-ui-dashboard-pro?ref=vsud"
      type="button"
      >Upgrade to pro</a
    >
  </div>
</template>
<script>
import SidenavCollapse from './SidenavCollapse.vue'
import SidenavCard from './SidenavCard.vue'
import FilterList from '@/Components/Map/Filters/FilterList'

export default {
  name: 'SidenavList',
  components: {
    FilterList,
    SidenavCollapse,
    SidenavCard,
  },
  props: {
    cardBg: String,
  },
  data () {
    return {
      title: '',
      controls: '',
      isActive: 'active',
    }
  },
  computed: {
    showMapFilters () {
      return this.$page.component === 'Map'
    },
  },
}
</script>
