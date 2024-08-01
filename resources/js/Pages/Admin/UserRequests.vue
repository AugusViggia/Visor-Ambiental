<template>
  <InertiaHead title="Solicitudes de Usuario - Pendientes" />

  <Search :clear-url="route('userRequests.index', {type: currentType})" :filters="filters" />
      <div v-if="requests.data.length > 0" class="table-responsive">
        <PendingList v-if="currentType === 'pending'" :list="requests.data" />
        <RejectedList v-if="currentType === 'rejected'" :list="requests.data" />
      </div>
      <Pagination v-if="requests.data.length > 0"
        :links="requests.links"
        :meta="requests.meta"
      />
      <ActionMessage
        :on="requests.data.length === 0"
        custom-class="alert-sucess text-white"
      >
        {{ $__('No results.') }}
      </ActionMessage>
</template>

<script>
import { InertiaHead } from '@inertiajs/inertia-vue3'
import UserRequestsLayout from '@/Pages/Admin/Layouts/UserRequestsLayout'
import AppLayout from '@/Layouts/AppLayout'
import Search from '@/Pages/Admin/Partials/SearchUserRequests'
import Pagination from '@/Components/Pagination'
import ActionMessage from '@/Jetstream/ActionMessage'
import PendingList from '@/Pages/Admin/Partials/PendingList'
import RejectedList from '@/Pages/Admin/Partials/RejectedList'

export default {
  components: {
    RejectedList,
    PendingList,
    ActionMessage,
    InertiaHead,
    Search,
    Pagination,
  },
  layout: [AppLayout, UserRequestsLayout],

  props: {
    requests: {
      type: [Array, Object],
      required: true,
    },
    filters: {
      type: Object,
      default: () => null,
    },
    errors: Object,
  },

  computed: {
    currentType () {
      return this.filters ? this.filters.type : null
    },
  },
}
</script>
