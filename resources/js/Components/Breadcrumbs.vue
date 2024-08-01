<template>
  <nav aria-label="breadcrumb">
    <ol v-if="hasBreadcrumbs"
      class="px-0 pt-1 pb-0 mb-0 bg-transparent breadcrumb me-sm-6"
    >
      <li
        v-for="(breadcrumb) in breadcrumbs"
        :key="breadcrumb.url"
        :class="[
          'text-sm breadcrumb-item',
          textWhite,
          breadcrumb.is_current_page ? 'active' : ''
        ]"
      >
        <a
          v-if="!breadcrumb.is_current_page"
          :class="textWhite"
          class="opacity-8"
          :href="breadcrumb.url"
          :title="breadcrumb.title"
        >
          {{ breadcrumb.title }}
        </a>
        <span
          v-else
          :class="textWhite ? 'text-white' : 'text-dark'"
          aria-current="page"
        >
          {{ breadcrumb.title }}
        </span>
      </li>
    </ol>
    <h6 class="mb-0 font-weight-bolder" :class="textWhite ? 'text-white' : ''">
      {{ currentPage }}
    </h6>
  </nav>
</template>

<script>
export default {
  name: 'app-breadcrumbs',
  props: {
    textWhite: {
      type: String,
    },
  },

  computed: {
    breadcrumbs () {
      return this.$page.props.breadcrumbs
    },
    currentPage () {
      if (!this.breadcrumbs) {
        return ''
      }

      const currents = this.$page.props.breadcrumbs
        .filter(breadcrumb => breadcrumb.is_current_page)
      if (currents.length > 0) {
        return currents.pop().title
      }

      return ''
    },
    hasBreadcrumbs () {
      return this.breadcrumbs && this.breadcrumbs.length > 0
    },
  },
}
</script>
